<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddMissingColumnsToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. team_members: add is_leadership
        if (Schema::hasTable('team_members')) {
            Schema::table('team_members', function (Blueprint $table) {
                if (!Schema::hasColumn('team_members', 'is_leadership')) {
                    $table->boolean('is_leadership')->default(false)->after('instagram');
                }
            });

            // Set existing Chairman & Executive to leadership
            DB::table('team_members')->where('id', 1)->update(['is_leadership' => 1]);
            DB::table('team_members')->where('id', 2)->update(['is_leadership' => 1]);
        }

        // 2. contact_leads: add subject and source_page
        if (Schema::hasTable('contact_leads')) {
            Schema::table('contact_leads', function (Blueprint $table) {
                if (!Schema::hasColumn('contact_leads', 'subject')) {
                    $table->string('subject', 255)->nullable()->after('email');
                }
                if (!Schema::hasColumn('contact_leads', 'source_page')) {
                    $table->string('source_page', 255)->nullable()->after('message');
                }
            });
        }

        // 3. distributor_applications: add address and current_brands
        if (Schema::hasTable('distributor_applications')) {
            Schema::table('distributor_applications', function (Blueprint $table) {
                if (!Schema::hasColumn('distributor_applications', 'address')) {
                    $table->text('address')->nullable()->after('city');
                }
                if (!Schema::hasColumn('distributor_applications', 'current_brands')) {
                    $table->text('current_brands')->nullable()->after('experience_years');
                }
            });
        }

        // 4. testimonials: add school_name and image aliases for complete DB compatibility
        if (Schema::hasTable('testimonials')) {
            Schema::table('testimonials', function (Blueprint $table) {
                if (!Schema::hasColumn('testimonials', 'school_name')) {
                    $table->string('school_name', 255)->nullable()->after('institution');
                }
                if (!Schema::hasColumn('testimonials', 'image')) {
                    $table->string('image', 255)->nullable()->after('avatar');
                }
            });

            // Sync existing data
            DB::statement("UPDATE `testimonials` SET `school_name` = `institution` WHERE `school_name` IS NULL AND `institution` IS NOT NULL");
            DB::statement("UPDATE `testimonials` SET `image` = `avatar` WHERE `image` IS NULL AND `avatar` IS NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('team_members')) {
            Schema::table('team_members', function (Blueprint $table) {
                if (Schema::hasColumn('team_members', 'is_leadership')) {
                    $table->dropColumn('is_leadership');
                }
            });
        }

        if (Schema::hasTable('contact_leads')) {
            Schema::table('contact_leads', function (Blueprint $table) {
                if (Schema::hasColumn('contact_leads', 'subject')) {
                    $table->dropColumn('subject');
                }
                if (Schema::hasColumn('contact_leads', 'source_page')) {
                    $table->dropColumn('source_page');
                }
            });
        }

        if (Schema::hasTable('distributor_applications')) {
            Schema::table('distributor_applications', function (Blueprint $table) {
                if (Schema::hasColumn('distributor_applications', 'address')) {
                    $table->dropColumn('address');
                }
                if (Schema::hasColumn('distributor_applications', 'current_brands')) {
                    $table->dropColumn('current_brands');
                }
            });
        }

        if (Schema::hasTable('testimonials')) {
            Schema::table('testimonials', function (Blueprint $table) {
                if (Schema::hasColumn('testimonials', 'school_name')) {
                    $table->dropColumn('school_name');
                }
                if (Schema::hasColumn('testimonials', 'image')) {
                    $table->dropColumn('image');
                }
            });
        }
    }
}

