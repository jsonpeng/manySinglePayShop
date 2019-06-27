<?php

namespace App\Repositories;

use App\Models\Loans;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/**
 * Class LoansRepository
 * @package App\Repositories
 * @version August 17, 2018, 3:37 pm CST
 *
 * @method Loans findWithoutFail($id, $columns = ['*'])
 * @method Loans find($id, $columns = ['*'])
 * @method Loans first($columns = ['*'])
*/
class LoansRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'link',
        'edu_qi',
        'edu_zhi',
        'qixian_qi',
        'qixian_zhi',
        'qixian_type',
        'lilv',
        'num'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Loans::class;
    }

    public function randomLoans(){
        return Loans::orderBy(\DB::raw('RAND()'))->take(3)->get();
    }

    public function allLoans(){
        return Cache::remember('zcjy_all_loans', Config::get('web.shrottimecache'), function(){
        return Loans::orderBy('created_at','desc')->get();
        });
    }



}
