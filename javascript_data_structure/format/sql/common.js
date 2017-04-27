let func = {
    sql : (str)=>{
        console.log(sql);
    },
    trim : (str)=>{
        // split
    }
};

let keyWord = {
    curd : [
            'SELECT','UPDATE','DELETE','INSERT',
            'REPLACE INTO'
        ],
    field,
    join : ['LEFT','INNER','JOIN','RIGHT']
};

console.log(keyWord.curd);

func['sql']('select * from ');