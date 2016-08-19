<?php

namespace ABO\MainBundle\Event;

final class ABOMatejerEvents {

    /*
     * The EMAIL_SPOILED event occurs when an email is spoiled in a file.
     *
     * This event allows you to send the spoiled email using the console command.
     * The event listener method receives the method used in ABOMail service to send the email, the subject and the receiver(email).
     */
    const EMAIL_SPOILED = 'abo.email_spoiled_event';
    
    /*
     * The RESETTING_REQUEST_INITIALIZE event occurs a user request a password recovery.
     *
     * This event allows you to check if the user email is confirmed or not.
     * The event listener method receives an instance of the UserInterface.
     */
    const RESETTING_REQUEST_INITIALIZE = 'abo.resetting_request_initialize';
    
    /*
     * The SHOP_NEW_EMAIL event occurs when a shop change/add an email.
     *
     * WHAT LISTENER WILL DO:
     * - check if the email is the same as the user email => no confirmation needed.
     * - if email needs confirmation the listener will generate a unique confirmation token and set a deadline.
     * - send an email to the user telling him that he needs to confirm his shop email
     * - send a confirmation email.
     */
    const SHOP_NEW_EMAIL = 'abo.shop_new_email';
    
    /*
     * The SHOP_EMAIL_CONFIRMATION event occurs when a shop email request confirmation and token match.
     *
     * WHAT LISTENER WILL DO:
     * - Confirm the email: 
     *  code => '', deadline => new \DateTime, confirmed => true
     * - send email confirming confirmation success
     * - send an email to the user
     */
    const SHOP_EMAIL_CONFIRMATION = 'abo.shop_email_confirmation';
    
    /*
     * The SHOP_REGISTRATION_SUCCESS event occurs when a shop is registred.
     *
     * WHAT LISTENER WILL DO:
     * - Tag the shop
     */
    const SHOP_REGISTRATION_SUCCESS = 'abo.shop_registration_success';
    
    /*
     * The VALID_PRODUCT_SUBMISSION event occurs when a product form is submitted and validated
     *
     * WHAT LISTENER WILL DO:
     * - save categoryProduct
     * - upload images
     * - persist images and ProdImgs
     * - save product sizes
     * - Tag the product
     */
    const VALID_PRODUCT_SUBMISSION = 'abo.valid_product_submission';
    
    /*
     * The VALID_SPECIFICATIONS_SUBMISSION event occurs when a product form is submitted and validated
     *
     * WHAT LISTENER WILL DO:
     * - handle the submition of the form
     */
    const VALID_SPECIFICATION_SUBMISSION = 'abo.valid_specification_submission';
    
    /*
     * The USER_CHANGE_LANGUAGE event occurs when use changes his language
     *
     * WHAT LISTENER WILL DO:
     * - update session _locale
     */
    const USER_CHANGE_LANGUAGE = 'abo.user_change_language';
    
}
