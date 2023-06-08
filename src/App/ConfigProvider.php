<?php
/**
 * @copyright Copyright © 2014 Rollun LC (http://rollun.com/)
 * @license LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace App;

use App\Callbacks\UpdateOrderCallback;
use App\Callbacks\UpdateOrderCallbackFactory;
use rollun\callback\Callback\Factory\CallbackAbstractFactoryAbstract;
use rollun\callback\Callback\Factory\MultiplexerAbstractFactory;
use rollun\callback\Callback\Factory\SerializedCallbackAbstractFactory;
use rollun\callback\Callback\Interrupter\Factory\InterruptAbstractFactoryAbstract;
use rollun\callback\Callback\Interrupter\Factory\ProcessAbstractFactory;
use rollun\callback\Callback\Interrupter\Process;
use rollun\callback\Callback\Multiplexer;
use rollun\callback\Middleware\CallablePluginManagerFactory;
use rollun\tableGateway\Factory\TableGatewayAbstractFactory;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            TableGatewayAbstractFactory::KEY => [
                'orders' => [],
            ],
            CallbackAbstractFactoryAbstract::KEY => [
                'multiplexer' => [
                    MultiplexerAbstractFactory::KEY_CLASS => Multiplexer::class,
                    MultiplexerAbstractFactory::KEY_CALLBACKS_SERVICES => [
                        'processInterrupter',
                        'processInterrupter',
                        'processInterrupter',
                    ]
                ],
            ],
            CallablePluginManagerFactory::KEY_INTERRUPTERS => [
                'factories' => [
                    'UpdateOrderCallback' => UpdateOrderCallbackFactory::class,
                ],
            ],
            SerializedCallbackAbstractFactory::class => [
                'SerializedUpdateOrderCallback' => UpdateOrderCallback::class,
            ],
            InterruptAbstractFactoryAbstract::KEY => [
                'processInterrupter' => [
                    ProcessAbstractFactory::KEY_CLASS => Process::class,
                    ProcessAbstractFactory::KEY_CALLBACK_SERVICE => 'SerializedUpdateOrderCallback',
                ],
            ],
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'abstract_factories' => [
                ProcessAbstractFactory::class,
                SerializedCallbackAbstractFactory::class,
            ],
            'factories' => [
                Handler\MyHandler::class => Handler\MyHandlerFactory::class,
                UpdateOrderCallback::class => UpdateOrderCallbackFactory::class,
            ],
            'invokables' => [
                Handler\HomePageHandler::class => Handler\HomePageHandler::class,
            ],

        ];
    }
}
