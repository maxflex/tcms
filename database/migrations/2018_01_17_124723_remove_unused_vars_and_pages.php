<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnusedVarsAndPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('pages')->whereNotIn('id', [35, 354])->update(['deleted_at' => now()]);
        \DB::table('pages')->whereId(354)->update(['group_id' => 7]);
        \DB::table('page_groups')->where('id', '<>', 7)->delete();
        \DB::table('variables')->whereIn('id', [1020, 7, 14, 1056, 1059, 10, 1005, 1009, 1051, 1052, 1053, 1054, 11, 30 , 1007, 23, 26, 1048, 21, 17, 1006, 1044, 17, 1043, 1045])->update(['deleted_at' => now()]);
        $this->deleteUnusedVars();
        \DB::table('variable_groups')->whereIn('id', [1005, 1002, 1000, 1001, 1008, 1007, 1009])->delete();
    }

    private function deleteUnusedVars()
    {
        $vars = \DB::table('variables')->pluck('name');

        foreach($vars as $var) {
            $used = \DB::table('variables')->where('html', 'like', "%[{$var}%")->whereNull('deleted_at')->exists();
            if (! $used) {
                $used = \DB::table('pages')->whereRaw("(html like '%[{$var}%' or html_mobile like '%[{$var}%')")->whereNull('deleted_at')->exists();
            }
            if (! $used) {
                // echo $var . PHP_EOL;
                \DB::table('variables')->whereName($var)->update(['deleted_at' => now()]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
