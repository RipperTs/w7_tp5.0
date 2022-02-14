<?php
/**
 * 后台菜单配置
 *    'home' => [
 *       'name' => '首页',                // 菜单名称
 *       'icon' => 'icon-home',          // 图标 (class)
 *       'index' => 'index/index',         // 链接
 *     ],
 */
return [
    'index' => [
        'name' => '首页',
        'icon' => 'icon-home',
        'index' => 'index/index',
    ],
    'store' => [
        'name' => '管理员',
        'icon' => 'icon-guanliyuan',
        'index' => 'store.user/index',
        'submenu' => [
            [
                'name' => '管理员列表',
                'index' => 'store.user/index',
                'uris' => [
                    'store.user/index',
                    'store.user/add',
                    'store.user/edit',
                    'store.user/delete',
                ],
            ],
            [
                'name' => '角色管理',
                'index' => 'store.role/index',
                'uris' => [
                    'store.role/index',
                    'store.role/add',
                    'store.role/edit',
                    'store.role/delete',
                ],
            ],
        ]
    ],
    'generate' => [
        'name' => '赋能记录',
        'icon' => 'icon-order',
        'index' => 'generate/lists',
        'submenu' => [
            [
                'name' => '赋能记录列表',
                'index' => 'generate/lists',
            ],
        ]
    ],
    'user' => [
        'name' => '用户管理',
        'icon' => 'icon-user',
        'index' => 'user/index',
        'submenu' => [
            [
                'name' => '用户列表',
                'index' => 'user/index',
            ],
            [
                'name' => '余额充值',
                'active' => true,
                'submenu' => [
                    [
                        'name' => '充值记录',
                        'index' => 'user.recharge/order',
                    ],
                    [
                        'name' => '余额明细',
                        'index' => 'user.balance/log',
                    ],
                ]
            ],
        ]
    ],

    'market' => [
        'name' => '营销管理',
        'icon' => 'icon-marketing',
        'index' => 'market.recharge.plan/index',
        'submenu' => [
            [
                'name' => '用户充值',
                'submenu' => [
                    [
                        'name' => '充值套餐',
                        'index' => 'market.recharge.plan/index',
                        'uris' => [
                            'market.recharge.plan/index',
                            'market.recharge.plan/add',
                            'market.recharge.plan/edit',
                        ]
                    ],
                    [
                        'name' => '充值设置',
                        'index' => 'market.recharge/setting'
                    ],
                ]
            ],
        ],
    ],
//    'statistics' => [
//        'name' => '数据统计',
//        'icon' => 'icon-qushitu',
//        'index' => 'statistics.data/index',
//    ],
    'wxapp' => [
        'name' => '公众号',
        'icon' => 'icon-wxapp',
        'color' => '#36b313',
        'index' => 'wxapp/setting',
        'submenu' => [
            [
                'name' => '公众号设置',
                'index' => 'wxapp/setting',
            ],
            [
                'name' => '首页模块',
                'active' => true,
                'submenu' => [
                    [
                        'name' => '轮播图',
                        'index' => 'wxapp.banner/index',
                        'uris' => [
                            'wxapp.banner/index',
                            'wxapp.banner/add',
                            'wxapp.banner/edit',
                        ]
                    ]
                ]
            ],
            [
                'name' => '帮助中心',
                'index' => 'wxapp.help/index',
                'uris' => [
                    'wxapp.help/index',
                    'wxapp.help/add',
                    'wxapp.help/edit'
                ]
            ],
            [
                'name' => '程序包',
                'index' => 'wxapp/down',
            ],
        ],
    ],

    'setting' => [
        'name' => '设置',
        'icon' => 'icon-setting',
        'index' => 'setting/store',
        'submenu' => [
            [
                'name' => '系统名称',
                'index' => 'setting/store',
            ],
            [
                'name' => '上传设置',
                'index' => 'setting/storage',
            ],
            [
                'name' => '其他',
                'submenu' => [
                    [
                        'name' => '清理缓存',
                        'index' => 'setting.cache/clear'
                    ]
                ]
            ]
        ],
    ],
];
