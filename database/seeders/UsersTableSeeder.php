<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\User;    //教材8.4节添加

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(100)->create();

        //教材8.4节里有这段来定义1号用户，我觉得可能不需要，就让它自己随机生成全部的假用户 ——实操验证确实不需要——验证了这个之后我取消了下方的这段的注释
        $user = User::find(1);
        $user->name = 'Zhangshiyu';
        $user->email = 'admin@jiaocai1.ml';
        $user->password = bcrypt('111111');   //这行是我自己加的
        //$user->is_admin = true;     //这行是教材8.6删除用户前要添加一个管理员。添加管理员之前要make一个迁移文件，迁移文件中设置is_admin，然后要做migrate→此时user表中就有了is_admin字段→然后回到这里设定第一个用户为admin
        $user->save();
    }
}
