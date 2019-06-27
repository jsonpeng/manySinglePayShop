<?php

namespace App\Repositories;

use App\Models\Certs;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CertsRepository
 * @package App\Repositories
 * @version November 27, 2018, 4:57 pm CST
 *
 * @method Certs findWithoutFail($id, $columns = ['*'])
 * @method Certs find($id, $columns = ['*'])
 * @method Certs first($columns = ['*'])
*/
class CertsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'id_card_name',
        'id_card_num',
        'id_card_time_type',
        'id_card_zhengmian',
        'id_card_fanmian',
        'id_card_shouchi'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Certs::class;
    }

    //保存用户认证信息
    public function saveUserCert($user,$input){
        $varify = varifyInputParam($input,$this->fieldSearchable);
        if($varify){
            return zcjy_callback_data($varify,1);
        }
        $input['user_id'] = $user->id;
        Certs::create($input);
        return zcjy_callback_data('提交成功,请等待系统审核');
    }
    
}
