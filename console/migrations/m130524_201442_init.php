<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        /*
         * CLIENTS
         * */

        $this->createTable('clients', [
            'id' => $this->primaryKey(),
            'registration_type' => $this->smallInteger(1)->notNull(),
            'name' => $this->string(31)->notNull(),
            'phone' => $this->integer()->unique(),
            'email' => $this->string(31)->unique(),
            'socialID' => $this->string(31)->unique(),
            'password_hash' => $this->string(),
            'status' => $this->smallInteger(1),

            'coupons' => $this->string(), // json
        ], $tableOptions);

        /*
         * TOKENS
         * */

        $this->createTable('tokens', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'user_type' => $this->smallInteger(2),
            'type' => $this->smallInteger(2),
            'value' => $this->string(63)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('FK_clients_tokens', 'tokens', 'user_id', 'clients', 'id', 'CASCADE', 'CASCADE');

        /*
         * SETTINGS
         * */

        $this->createTable('settings', [
            'id' => $this->primaryKey(),
            'alias' => $this->string()->notNull()->unique(),
            'name' => $this->string()->notNull()->unique(),
            'value' => $this->string()->notNull()
        ]);

        /*
         * REQUESTS LOGS
         * */

        $this->createTable('requests_logs', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'controller' => $this->string()->notNull(),
            'action' => $this->string()->notNull(),
            'method' => $this->string()->null(),
            'request' => $this->text()->null(),
            'response' => $this->text()->null(),
            'error' => $this->text()->null(),
            'device' => $this->text()->null(),
            'timestamp' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        /*
         *  ACTIONS
         * */

        $this->createTable('actions', [
            'id' => $this->primaryKey(),
            'start_date' => $this->integer(),
            'end_date' => $this->integer(),
            'min_summ' => $this->integer()->notNull(),
            'coupon_id' => $this->integer()->notNull(),
            'is_current' => $this->boolean()->notNull(),
        ]);

        /*
         * COUPONS
         * */

        $this->createTable('coupons', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique()->notNull(),
            'value' => $this->integer()->notNull(),
            'type' => $this->smallInteger(1)->notNull(),
            'end_time' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('FK_coupons_actions', 'actions', 'coupon_id', 'coupons', 'id', 'CASCADE', 'CASCADE');

        /*
         * PARTNERS
         * */

        $this->createTable('partners', [
            'id' => $this->primaryKey()->notNull(),
            'type' => $this->string(31)->notNull(),
            'desc' => $this->string(),
            'cities' => $this->string()->notNull(), //json
            'site' => $this->string(),
            'social' => $this->string(), // json
            'img_logotype' => $this->string(),
            'img_shop' => $this->string(),
            'img_team' => $this->string(),

            'status' => $this->integer(),
        ]);

        /*
         * BRANCHES
         * */

        $this->createTable('branches', [
            'id' => $this->primaryKey()->notNull(),
            'address' => $this->string(),
            'phone_sms' => $this->string(),
            'phone_client' => $this->string(),
            'email' => $this->string(),
            'work_time' => $this->string()->notNull(),
            'delivery_time' => $this->string()->notNull(),

            'partner_id' => $this->integer(),
        ]);

        $this->addForeignKey('FK_partners_branches', 'branches', 'partner_id', 'partners', 'id', 'CASCADE', 'CASCADE');

        /*
         * MERCHANTS
         * */

        $this->createTable('merchants', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string(),
            'phone' => $this->integer(11)->notNull(),
            'type' => $this->smallInteger(2),
            'partner_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'is_active' => $this->boolean(),
        ]);

        $this->addForeignKey('FK_partners_merchants', 'merchants', 'partner_id', 'partners', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_branches_merchants', 'merchants', 'branch_id', 'branches', 'id', 'CASCADE', 'CASCADE');

        /*
         * PRODUCTS
         * */

        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'photos' => $this->string(),
            'name' => $this->string()->notNull(),
            'price' => $this->integer()->notNull(),
            'discount' => $this->integer(),
            'discount_type' => $this->integer(),
            'composition' => $this->string(),
            'width' => $this->integer()->notNull(),
            'height' => $this->integer()->notNull(),
            'time' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'tags' => $this->string(),
            'description' => $this->string()->notNull(),

            'partner_id' => $this->integer()->notNull(),

            'status' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('FK_partners_products', 'products', 'partner_id', 'partners', 'id', 'CASCADE', 'CASCADE');

        /*
         * ORDERS
         * */

        $this->createTable('orders', [
            'id' => $this->primaryKey()->notNull(),

            'product_id' => $this->integer(),
            'product_price' => $this->integer(),
            'product_discount' => $this->integer(),
            'product_discount_type' => $this->integer(),

            'product_multiplier' => $this->integer(), // [ +30%, +50% ... ]

            'addit_products' => $this->string(), // json [[id, price, discount, discount_type], ... ]

            'coupon_id' => $this->integer(),
            'coupon_name' => $this->string(),
            'coupon_discount' => $this->integer(),
            'coupon_type' => $this->integer(),

            'addressee_name' => $this->string()->notNull(),
            'addressee_address' => $this->string()->notNull(),
            'addressee_apartments' => $this->integer()->notNull(),
            'addressee_phone' => $this->integer(11)->notNull(),

            'date' => $this->integer()->notNull(),
            'time' => $this->integer()->notNull(), // sprav

            'client_id' => $this->integer()->notNull(),
            'client_name' => $this->string()->notNull(),
            'client_phone' => $this->integer(11)->notNull(),
            'client_email' => $this->string(),

            'is_anonymous' => $this->boolean()->notNull(),

            'has_card' => $this->boolean()->notNull(),
            'card_reason' => $this->integer(),

            'comment' => $this->string(),

            'total_price' => $this->integer()->notNull(),

            'payment_type' => $this->integer()->notNull(),

            'status' => $this->integer()->notNull(),
        ]);

        /*
         * REVIEWS
         * */

        $this->createTable('reviews', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'client_name' => $this->string(),
            'partner_id' => $this->integer(),
            'partner_name' => $this->string(),
            'product_id' => $this->integer(),
            'product_name' => $this->string(),
            'date' => $this->integer()->notNull(),
            'detailed_estimate' => $this->string(), // json [ [id (sprav), estimate], [], ... ]
            'estimate' => $this->integer()->notNull(),
            'text' => $this->string(),
        ]);

        /*
         * ADMINS
         * */

        $this->createTable('admins', [
            'id' => $this->integer(),
            'login' => $this->integer(),
            'password_hash' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('admins');

        $this->dropTable('reviews');

        $this->dropTable('orders');

        $this->dropForeignKey('FK_partners_products', 'products');
        $this->dropTable('products');

        $this->dropForeignKey('FK_branches_merchants', 'merchants');
        $this->dropForeignKey('FK_partners_merchants',  'merchants');
        $this->dropTable('merchants');

        $this->dropForeignKey('FK_partners_branches', 'branches');
        $this->dropTable('branches');
        $this->dropTable('partners');

        $this->dropForeignKey('FK_coupons_actions', 'actions');
        $this->dropTable('coupons');

        $this->dropTable('actions');

        $this->dropTable('requests_logs');
        $this->dropTable('settings');


        $this->dropForeignKey('FK_clients_tokens', 'tokens');

        $this->dropTable('tokens');

        $this->dropTable('clients');
    }
}
