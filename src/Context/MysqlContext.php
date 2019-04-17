<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2019-02-13
 * Time: 15:44
 *
 */

namespace Miapenso\Easyswoole\Context;

use EasySwoole\Component\Context\ContextItemHandlerInterface;
use EasySwoole\Component\Pool\PoolManager;
use Miapenso\Easyswoole\Pools\MysqlObject;
use Miapenso\Easyswoole\Pools\MysqlPool;


class MysqlContext implements ContextItemHandlerInterface{
	const KEY = 'MYSQL';
    function onContextCreate(){

    }
    function onDestroy($context){
        if( $context instanceof MysqlObject ){
            $context->gc();
            PoolManager::getInstance()->getPool( MysqlPool::class )->recycleObj( $context );
        }
    }
}