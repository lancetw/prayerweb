<?php

Event::listen('cron.collectJobs', function() {

    // 每個工作日早上八點十分發每日通知
    Cron::add('每個工作日早上八點十分發每日通知', '10 8 * * 1-5', function() {
        // Do some crazy things successfully every hour
    }, true);

    // 每星期五早上八點十分發每週通知
    Cron::add('每星期五早上八點十分發每週通知', '10 8 * * 5', function() {
        // Do some crazy things successfully every hour
    }, true);

    // 每月的第一天早上八點十分發每月通知
    Cron::add('每月的第一天早上八點十分發每月通知', '10 8 1 * *', function() {
        // Do some crazy things successfully every hour
    }, true);
});
