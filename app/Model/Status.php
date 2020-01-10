<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Status extends Model{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'status';
    protected $primaryKey = 'status_id';

    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 可以被批量赋值的属性.
     *白名单
     * @var array
     */
    //protected $fillable = ['bname,blogo,burl,bdesc'];

    /**
     * 不能被批量赋值的属性
     *黑名单
     * @var array
     */
    protected $guarded = [];
}
