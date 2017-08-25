# 对接hubspot

## 需求

需要把数据库中所有符合条件的`user`用户信息（大概 6W 条信息）都发送至第三方网站 `hubspot` 上。要求数据有更改或者有新的符合条件的数据，能动态更新至 `hubspot` （最大可以延迟一天更新最新数据）。

## 实现

### 实现一

我的想法是：

新建一张`hubspot_data`表，表里存储所有要发送的用户信息。

表中有个字段`is_need_send` , 0 代表不需要发送至 `hubspot` ，1 代表需要发送。

先写一个脚本，把所有的数据到生成至 `hubspot_data` 表，`is_need_send` 设置为 1 。

再弄两个定时任务：

第一个定时任务负责发送`hubspot_data`表数据至hubspot。

    每3分钟获取300条is_need_send=1的数据，通过hubspot提供的api分三次发送（该API限制为一次最多发送100个用户）至hubspot 。 发送完之后设置此300条用户的is_need_send=0.

第二个定时任务负责更新`hubspot_data`表数据

    每天第一次运行时获取所有符合条件的user用户信息，存入到缓存文件中，后面每次运行则从该缓存脚本中获取前300条信息，循环和 hubspot_data 表中的数据对比，只要有一个字段值不一样，则更新数据，如果不存在则插入，最后设置is_need_update=1.

但是这种方式被否决了。

原因在于，6W的总量，每天需要更新的数据量只有600左右，为了这600条用户的更新，每次脚本运行都要执行大量 `sql` 来对比数据。也就是说 ，其中 90%的操作都是废的。

### 实现二

还有种方式：在代码中找到所有需要发送的用户信息字段，只要有更改，就手动添加一条语句，来更新 `hubspot_data` 表数据（或者直接发送）。

但是这种方式被我否决了 。

原因在于这是个维护已超10年的老项目，里面的代码逻辑异常复杂。谁也不知道哪里就有个地方修改了需要的字段。这个思路的工程量太大~

### 实现三

最后选中了第三个方法：给 `hubspot_data` 表增加一个为 `is_need_update`, 0 代表不需要更新数据，1代表需要更新数据。再给涉及到数据数据表加触发器，表数据有更新插入删除时，触发器触发 `hubspot_data` 对应表中用户，更改 `is_need_update=1` 。上面的第二个定时任务就可以更改为每天运行3次，每次获取300条is_need_update=1 的数据更新数据，更新之后设置 `is_need_update=0` 。

第三种方式，开发的代码量最少，对数据库的操作也降到了最低。

## 坑

### 坑一

`hubspot` 的属性有个叫 `datetime` 的类型。这个类型的属性值，是毫秒级的。这个类型的属性，只能通过API创建。
还有个叫 `Date` 的类型，这个类型的属性，可以在 `hubspot` 网站上创建，但是他必须是 `UTC` 时区的凌晨，否则更新数据会失败。

[关于data类型属性](https://developers.hubspot.com/docs/faq/how-should-timestamps-be-formatted-for-hubspots-apis)

### 坑二

`hubspot` 有个 `api` 可以一次更新多条信息，但是如果这多条信息中，有一条更新失败，那么该次请求所有的数据都更新失败。所以必须处理更新失败的用户，将失败用户 `is_need_update` 设置为非0非1（以防每次更新数据遇到错误用户信息一直更新失败又一直更新陷入循环）。

[批量更新](https://developers.hubspot.com/docs/methods/contacts/batch_create_or_update)
原文：When using this endpoint, please keep in mind that any errors with a single contact in your batch will prevent the entire batch from processing. If this happens, we'll return a 400 response with additional details as to the cause.

### 坑三

最后一个坑：因为我知道每天的更新量大概在600条左右，每天运行3次，大概一次也就更新200数据，所以第二条更新数据的定时任务没有限定条数 。 正常情况下没任何问题。直到有一天，，，，，

需要给 `users`表增加一个字段，设置所有的用户该字段值为 `1` 。 由于触发器的存在，导致 `hubspot_data` 所有数据的`is_need_update`都为 `1` .所以该定时任务运行时需要 `6W` 数据数据做循环处理，服务器妥妥的挂了。。。。（服务器只有1G内存）。

## 触发器

贴上其中2条触发器

```sql
## edit updateUserCIM trigger（update user CIM info trigger）
DELIMITER ;;
create trigger updateUserCIM
             after UPDATE on user_cim_details
             for each row
BEGIN
  update hubspot_data SET is_need_update = 1 where user_id = NEW.user_id;
END;;
DELIMITER ;
```

```sql
## create insert_hubspot trigger（ insert user trigger）
DROP TRIGGER insert_hubspot;
DELIMITER ;;
create trigger insert_hubspot
             after INSERT on users
             for each row
BEGIN
  REPLACE into hubspot_data(user_id, email,is_need_update) VALUE (NEW.id,NEW.email,1);
END;;
DELIMITER ;
```

```sql
## edit UserStatusUpdateDate trigger（update user's status trigger）
DELIMITER ;;
create trigger UserStatusUpdateDate
     before UPDATE on users
     for each row
IF NOT(NEW.user_status <=> OLD.user_status) THEN
update hubspot_data
    set is_need_update = CASE
    when new.user_status in ('C','G') then 2 else 1
    end
where user_id = old.id;
END IF;;
DELIMITER ;
```

## 结尾

结尾没啥好说的啦，此文不是讲如何对接、调用 `hubspot` 的 `api` ，主要讲如何分析一个需求，以最优方案解决。

关于如何对接、调用 `hubspot API` ，可以阅读其开发文档：[HubSpot API Overview](https://developers.hubspot.com/docs/overview) ， 这个 `api` 文档网页，可以直接在上面测试，非常赞的一个功能。

`github` 上有别人写好的类库可以直接拿来用 [hubspot](https://github.com/ryanwinchester/hubspot) 。不过这个使用的 `api` 都是比较古老的。限于的`php` 版本，我只能用这个了。最新的 `API` 的使用，可以参阅其 `README.md`文件。其中他没有实现批量更新的 `API` ,这里给出我自己的一个实现：

在 `src/Fungku/HubSpot/API/Contacts.php`文件加入以下代码：

```php
/**
 * Create a group of contacts or update them if they already exist.
 *
 * eg:
 * array(
 * array('email'=>'testBatch5@qq.com','param'=>array('firstname'=>'JasonT5','lastname'=>'Zhang5','phone'=>'555-122-2325','ispaid'=>'No')),
 * array('email'=>'testBatch6@qq.com','param'=>array('firstname'=>'JasonT6','lastname'=>'Zhang6','phone'=>'555-122-2326','ispaid'=>'No')),
 * array('email'=>'testBatch7@qq.com','param'=>array('firstname'=>'JasonT7','lastname'=>'Zhang7','phone'=>'555-122-2327','ispaid'=>'No')),
 * array('email'=>'testBatch8@qq.com','param'=>array('firstname'=>'JasonT8','lastname'=>'Zhang8','phone'=>'555-122-2328','ispaid'=>'No')),
 * )
 *
 * @param params: array of properties and property values for new contact, email is required
 *
 * @return Response body with JSON object
 * for created Contact from HTTP POST request
 *
 * @throws HubSpotException
 **/
public function batch_create_or_update($params){
    $endpoint = 'contact/batch/';
    $properties = array();
    foreach ($params as $k => $param) {
        $propertie = array();
        foreach ($param['param'] as $key => $value){
            array_push($propertie, array("property"=>$key,"value"=>$value));
        }
        $properties[$k]['properties'] = $propertie;
        if(!empty($param['vid'])){
            $properties[$k]['vid'] = $param['vid'];
        }elseif (!empty($param['email'])){
            $properties[$k]['email'] = $param['email'];
        }else
            continue;
    }
    $properties = json_encode($properties);
    try{
        return json_decode($this->execute_JSON_post_request($this->get_request_url($endpoint,null),$properties));
    } catch (HubSpotException $e) {
        throw new HubSpotException('Unable to create contact: ' . $e);
    }
}
```

如果开发过程中遇到任何问题，可以到 [hubspot开发者社区](https://integrate.hubspot.com/)寻求帮助，支持github账号登录哦~
