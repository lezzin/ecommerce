<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ecommerce extends Migration
{
    public function up()
    {
        // Create table 'user'
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'unique' => TRUE,
                'null' => FALSE
            ],
            'password_hash' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => TRUE,
                'null' => FALSE
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'phone_number' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ],
            'user_type' => [
                'type' => 'ENUM("admin","customer","vendor")',
                'default' => 'customer',
                'null' => FALSE
            ]
        ]);
        $this->forge->addKey('user_id', TRUE);
        $this->forge->createTable('user');

        // Create table 'category'
        $this->forge->addField([
            'category_id' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ]
        ]);
        $this->forge->addKey('category_id', TRUE);
        $this->forge->createTable('category');

        // Create table 'product'
        $this->forge->addField([
            'product_id' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'category_id' => [
                'type' => 'INT',
                'null' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => FALSE
            ]
        ]);
        $this->forge->addKey('product_id', TRUE);
        $this->forge->addForeignKey('category_id', 'category', 'category_id', "NULL", 'CASCADE');
        $this->forge->createTable('product');

        // Create table 'product_stock'
        $this->forge->addField([
            'product_stock_id' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'product_id' => [
                'type' => 'INT',
                'null' => TRUE
            ],
            'size' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => TRUE
            ],
            'quantity' => [
                'type' => 'INT',
                'null' => FALSE
            ]
        ]);
        $this->forge->addKey('product_stock_id', TRUE);
        $this->forge->addForeignKey('product_id', 'product', 'product_id', "NULL", 'CASCADE');
        $this->forge->createTable('product_stock');

        // Create table 'product_image'
        $this->forge->addField([
            'product_image_id' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'product_id' => [
                'type' => 'INT',
                'null' => TRUE
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ]
        ]);
        $this->forge->addKey('product_image_id', TRUE);
        $this->forge->addForeignKey('product_id', 'product', 'product_id', "NULL", 'CASCADE');
        $this->forge->createTable('product_image');

        // Create table 'config'
        $this->forge->addField([
            'config_id' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'top_message' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ],
            'banner_url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ]
        ]);
        $this->forge->addKey('config_id', TRUE);
        $this->forge->createTable('config');

        $this->db->query("INSERT INTO config(top_message, banner_url) VALUES (NULL, NULL)");

        // Create table 'shopping_cart'
        $this->forge->addField([
            'cart_id' => [
                'type' => 'INT',
                'auto_increment' => TRUE
            ],
            'customer_id' => [
                'type' => 'INT',
                'null' => TRUE
            ],
            'product_id' => [
                'type' => 'INT',
                'null' => TRUE
            ],
            'quantity' => [
                'type' => 'INT',
                'null' => FALSE
            ],
            'size' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => TRUE
            ]
        ]);
        $this->forge->addKey('cart_id', TRUE);
        $this->forge->addForeignKey('customer_id', 'user', 'user_id', "NULL", 'CASCADE');
        $this->forge->addForeignKey('product_id', 'product', 'product_id', "NULL", 'CASCADE');
        $this->forge->createTable('shopping_cart');
    }

    public function down()
    {
        $this->forge->dropTable('shopping_cart', TRUE);
        $this->forge->dropTable('config', TRUE);
        $this->forge->dropTable('product_image', TRUE);
        $this->forge->dropTable('product_stock', TRUE);
        $this->forge->dropTable('product', TRUE);
        $this->forge->dropTable('category', TRUE);
        $this->forge->dropTable('user', TRUE);
    }
}
