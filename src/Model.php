<?php

namespace Miapenso\Easyswoole;

use EasySwoole\Mysqli\TpORM;
use EasySwoole\EasySwoole\Config;
use EasySwoole\Component\Context\ContextManager;
use Miapenso\Easyswoole\Context\MysqlContext;
use Miapenso\Easyswoole\Pool\MysqlObject;
use EasySwoole\Mysqli\Exceptions\ConnectFail;
use EasySwoole\Mysqli\Exceptions\PrepareQueryFail;

/**
 * Class Model
 * @package ezswoole
 * @method mixed|static where($whereProps, $whereValue = 'DBNULL', $operator = '=', $cond = 'AND')
 *
 */
class Model extends TpORM
{
    protected $prefix;
    protected $limit;
    protected $throwable;
    protected $createTime = false;
    protected $createTimeName = 'create_time';
    protected $softDelete = false;
    protected $softDeleteTimeName = 'delete_time';

    /**
     * @param null $data
     */
    public function __construct( $data = null )
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

    /**
     * @param null $data
     * @return bool|int
     */
    protected function add( $data = null )
    {
        try{
            if( $this->createTime === true ){
                $data[$this->createTimeName] = time();
            }
            return parent::insert( $data );
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

    /**
     * @param null $data
     * @return bool|mixed
     */
    protected function edit( $data = null )
    {
        try{
            return $this->update( $data );
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

    /**
     * @return bool|null
     */
    protected function del()
    {
        try{
            if( $this->softDelete === true ){
                $data[$this->softDeleteTimeName] = time();
                return $this->update( $data );
            } else{
                return parent::delete();
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

    /**
     * @return array|bool|false|null
     */
    protected function select()
    {
        try{
            return parent::select();
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

    /**
     * @param string $name
     * @return array|bool
     */
    protected function column( string $name )
    {
        try{
            return parent::column( $name );
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

    /**
     * @param string $name
     * @return array|bool|null
     */
    protected function value( string $name )
    {
        try{
            return parent::value( $name );
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

    /**
     * @param string $column
     * @return array|bool|int|null
     */
    protected function count( string $column = '*')
    {
        try{
            return parent::count($column);
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

    /**
     * @return array|bool
     */
    protected function find( $id = null )
    {
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

    /**
     * @return Model
     */
    static function init()
    {
        return new static();
    }
}