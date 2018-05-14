<?php

/**
 * @name ActivSigninInfoModel
 * @info 描述：活动签到信息表model
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-5-14 17:20:17
 */

namespace Admin\Model;

use Think\Model;

class ActivSigninInfoModel extends Model {

    public $tableName = 'activ_signin_info';

    /**
     * 获取每个社区签到记录数量
     */
    public function getSignInCountGroupByAddress() {
        $this->dbFix = C('DB_PREFIX');
        return $this
            ->field("count(" . $this->dbFix . "activ_info.id) AS count," . $this->dbFix . "activ_info.address_id")
            ->join($this->dbFix . "activ_signin on " . $this->dbFix . "activ_signin.id = " . $this->dbFix . "activ_signin_info.sign_id", LEFT)
            ->join($this->dbFix . "activ_info on " . $this->dbFix . "activ_info.id = " . $this->dbFix . "activ_signin.activity_id", LEFT)
            ->group($this->dbFix . "activ_info.address_id")
            ->select();
    }

}
