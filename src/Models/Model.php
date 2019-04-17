<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-03-05
 * Time: 20:08
 */

namespace Miapenso\Easyswoole\Models;


use EasySwoole\Mysqli\TpORM;
use EasySwoole\EasySwoole\Config;
use Miapenso\Easyswoole\Context\MysqlContext;
use Miapenso\Easyswoole\Pools\MysqlObject;
use EasySwoole\Component\Context\ContextManager;
use EasySwoole\Mysqli\Exceptions\ConnectFail;
use EasySwoole\Mysqli\Exceptions\PrepareQueryFail;

class Model extends TpORM
{
    protected $prefix;
    protected $returnType = 'Array';

    public function __construct($data = null)
    {
        $this->prefix = Config::getInstance()->getConf( 'MYSQL.prefix' );
        $db = ContextManager::getInstance()->get(MysqlContext::KEY);
        if( $db instanceof MysqlObject ){
            parent::__construct( $data );
            $this->setDb( $db );
        } else{
            return null;
        }
    }
    protected function find($id=null){
        try{
            if( $id ){
                return $this->byId( $id );
            } else{
                return parent::find();
            }
        } catch( ConnectFail $e ){
            $this->throwable = $e;
            return false;
        } catch( PrepareQueryFail $e ){
            $this->throwable = $e;
            return false;
        } catch( \Throwable $t ){
            $this->throwable = $t;
            return false;
        }
    }

}