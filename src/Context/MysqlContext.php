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


use EasySwoole\Component\Pool\PoolManager;
use EasySwoole\Component\Context\ContextItemHandlerInterface;
use Miapenso\Easyswoole\Pool\MysqlObject;
use Miapenso\Easyswoole\Pool\MysqlPool;
use EasySwoole\EasySwoole\Config;

class MysqlContext implements ContextItemHandlerInterface{
	const KEY = 'MYSQL';
	function onContextCreate(){
		return PoolManager::getInstance()->getPool( MysqlPool::class )->getObj( Config::getInstance()->getConf( 'MYSQL.POOL_TIME_OUT' ) );
	}
	function onDestroy($context){
		if( $context instanceof MysqlObject ){
			$context->gc();
			PoolManager::getInstance()->getPool( MysqlPool::class )->recycleObj( $context );
		}
	}
}