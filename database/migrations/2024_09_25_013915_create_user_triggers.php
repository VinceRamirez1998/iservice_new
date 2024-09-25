<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class CreateUserTriggers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER insert_service_provider
            AFTER INSERT ON users
            FOR EACH ROW
            BEGIN
                IF NEW.role = "2" OR NEW.role = "provider" THEN
                    INSERT INTO service_providers (
                        name,
                        email,
                        phone,
                        complete_address,
                        role,
                        primary_id,
                        secondary_id,
                        service,
                        certification,
                        gender,
                        subscription_plan,
                        subscription_duration,
                        image,
                        user_id
                    ) VALUES (
                        NEW.name,
                        NEW.email,
                        NEW.phone,
                        NEW.complete_address,
                        NEW.role,
                        NEW.primary_id,
                        NEW.secondary_id,
                        NEW.service,
                        NEW.certification,
                        NEW.gender,
                        NEW.subscription_plan,
                        NEW.subscription_duration,
                        NEW.image,
                        NEW.id
                    );
                END IF;
            END;

            CREATE TRIGGER update_service_provider
            AFTER UPDATE ON users
            FOR EACH ROW
            BEGIN
                IF NEW.role = "2" OR NEW.role = "provider" THEN
                    UPDATE service_providers
                    SET 
                        name = NEW.name,
                        email = NEW.email,
                        phone = NEW.phone,
                        complete_address = NEW.complete_address,
                        role = NEW.role,
                        primary_id = NEW.primary_id,
                        secondary_id = NEW.secondary_id,
                        service = NEW.service,
                        certification = NEW.certification,
                        gender = NEW.gender,
                        subscription_plan = NEW.subscription_plan,
                        subscription_duration = NEW.subscription_duration,
                        image = NEW.image
                    WHERE user_id = NEW.id;

                    IF ROW_COUNT() = 0 THEN
                        INSERT INTO service_providers (
                            name,
                            email,
                            phone,
                            complete_address,
                            role,
                            primary_id,
                            secondary_id,
                            service,
                            certification,
                            gender,
                            subscription_plan,
                            subscription_duration,
                            image,
                            user_id
                        ) VALUES (
                            NEW.name,
                            NEW.email,
                            NEW.phone,
                            NEW.complete_address,
                            NEW.role,
                            NEW.primary_id,
                            NEW.secondary_id,
                            NEW.service,
                            NEW.certification,
                            NEW.gender,
                            NEW.subscription_plan,
                            NEW.subscription_duration,
                            NEW.image,
                            NEW.id
                        );
                    END IF;
                ELSEIF OLD.role = "2" OR OLD.role = "provider" THEN
                    DELETE FROM service_providers
                    WHERE user_id = OLD.id;
                END IF;
            END;

            CREATE TRIGGER delete_service_provider
            BEFORE DELETE ON users
            FOR EACH ROW
            BEGIN
                DELETE FROM service_providers
                WHERE user_id = OLD.id;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('
            DROP TRIGGER IF EXISTS insert_service_provider;
            DROP TRIGGER IF EXISTS update_service_provider;
            DROP TRIGGER IF EXISTS delete_service_provider;
        ');
    }
}
