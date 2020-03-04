<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateDailyTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        create trigger report_daily_trigger AFTER insert on transactions FOR EACH ROW
BEGIN
	DECLARE rowCount INT;
 
	SET rowCount = (SELECT count(*) FROM report_dailies WHERE date = Date(NEW.date) and type = new.type);
	IF rowCount = 0 THEN
		Insert into report_dailies(date,`amount`,type) values (Date(new.date),new.amount,new.type);
	ELSE
		Update report_dailies set `amount` = `amount` + new.amount WHERE date = Date(NEW.date) and type = new.type;
	END IF;
END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("Drop trigger report_daily_trigger");
    }
}
