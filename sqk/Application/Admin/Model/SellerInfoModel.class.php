<?php
/**
 * @name SellerInfoModel
 * @info 描述：商家信息模型
 * @author GX
 * @datetime 2017-2-15 13:29:13
 */
namespace Admin\Model;
use Think\Model;

class SellerInfoModel extends Model {
    public $tableName  = 'seller_info';
    protected $patchValidate = true;
    protected $_validate = [
        ['business_license', 'checkBusinessLicense', '营业执照号格式错误', 0 , 'callback'],
        ['name', 'require', '商家名称为必填项！'],
        ['name', '1,20', '商家名称长度应在1-20之间！', 0, 'length'],
        ['address_id', 'require', '注册社区必选！'],
        ['address', 'require', '商家地址为必填项！'],
        ['address', '1,300', '商家地址长度应在1-300之间！', 0, 'length'],
        ['contacts', 'require', '联系人为必填项！'],
        ['contacts', '1,10', '联系人长度应在1-10之间！', 0, 'length'],
        ['tel', 'require', '联系方式为必填项！'],
        ['tel', '/^((0\d{2,3}-\d{7,8})|(1[35789]\d{9}))$/', '联系方式格式不正确！'],
        ['tel', '', '该联系方式已经存在！', 0, 'unique', 3],
    ];

    //自定义函数验证营业执照号
    protected function checkBusinessLicense($BusinessLicense) {
        if(!isset($BusinessLicense) || empty($BusinessLicense)) {
            return false;
        }
        if(!in_array(strlen($BusinessLicense), [13, 16 ,18])) {
            return false;
        }
        return true;
    }

    //根据社区id获取该社区所有审核通过的商家
    public function getSellerListByAddressId($addressId) {
        $condition = [
            'address_id' => $addressId,
            'status' => 1
        ];
        return  $this->where($condition)->select();
    }

    //位方便列表搜索,给商家的状态配置新的对应关系
    public function sellerStatusMap() {
        return [
            ['status_code' => 1, 'status_name' => '未审核'],
            ['status_code' => 2, 'status_name' => '正常'],
            ['status_code' => 3, 'status_name' => '账号暂停'],
        ];
    }

    //获取全部(或当前社区)的商家数量
    public function getSellerCount($isAll = true) {
        $where = [];
        if($isAll == false) {
            if (session('sys_name') == 'sqAdmin') {
                $where['address_id'] = session('address_id');
            } else {
                return $this->count();
            }
        }
        return $this->where($where)->count();

    }


}