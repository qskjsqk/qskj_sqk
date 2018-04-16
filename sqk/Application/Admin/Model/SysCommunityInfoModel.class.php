<?php

/**
 * @name SysCommunityInfoModel
 * @info 描述：社区表model
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 10:35:17
 */

namespace Admin\Model;

use Think\Model;

class SysCommunityInfoModel extends Model {

    public $tableName = 'sys_community_info';

    public function getLists() {
        return $this->select();
    }

}
