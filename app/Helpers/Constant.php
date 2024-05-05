<?php

// All status
const PAYMENT_STATUS_PENDING = 0;
const PAYMENT_STATUS_PAID = 1;
const PAYMENT_STATUS_CANCELLED = 2;

const STATUS_PENDING = 0;
const STATUS_SUCCESS = 1;
const STATUS_REJECT = 3;
const STATUS_ACTIVE = 1;
const STATUS_DRAFT = 2;
const STATUS_DISABLE = 3;
const STATUS_DEACTIVATE = 3;
const STATUS_EXPIRED = 4;
const STATUS_SUSPENDED = 5;
const STATUS_CANCELED = 2;

// User Role Type
const USER_STATUS_ACTIVE = 1;
const USER_STATUS_INACTIVE = 0;
const USER_ROLE_ADMIN = 1;
const USER_ROLE_ALUMNI = 2;
const USER_ROLE_SUPER_ADMIN = 3;

// Message
const SOMETHING_WENT_WRONG = "Something went wrong! Please try again";
const CREATED_SUCCESSFULLY = "Created Successfully";
const UPDATED_SUCCESSFULLY = "Updated Successfully";
const DELETED_SUCCESSFULLY = "Deleted Successfully";
const UPLOADED_SUCCESSFULLY = "Uploaded Successfully";
const DATA_FETCH_SUCCESSFULLY = "Data Fetch Successfully";
const SENT_SUCCESSFULLY = "Sent Successfully";
const DO_NOT_HAVE_PERMISSION = 7;

// Currency placement
const CURRENCY_SYMBOL_BEFORE=1;

// storage driver
const STORAGE_DRIVER_PUBLIC = 'public';
const STORAGE_DRIVER_AWS = 'aws';
const STORAGE_DRIVER_WASABI = 'wasabi';
const STORAGE_DRIVER_VULTR = 'vultr';
const STORAGE_DRIVER_DO = 'do';

const ACTIVE = 1;
const DEACTIVATE = 0;

const GATEWAY_MODE_LIVE = 1;
const GATEWAY_MODE_SANDBOX = 2;

//Gateway name
const PAYPAL = 'paypal';
const STRIPE = 'stripe';
const RAZORPAY = 'razorpay';
const INSTAMOJO = 'instamojo';
const MOLLIE = 'mollie';
const PAYSTACK = 'paystack';
const SSLCOMMERZ = 'sslcommerz';
const MERCADOPAGO = 'mercadopago';
const FLUTTERWAVE = 'flutterwave';
const BANK = 'bank';
const COINBASE = 'coinbase';

const DURATION_TYPE_DAY = 1;
const DURATION_TYPE_MONTH = 2;
const DURATION_TYPE_YEAR = 3;
const DEPOSIT_TYPE_BUY = 1;
const DEPOSIT_TYPE_DEPOSIT = 2;

const ORDER_TYPE_DEPOSIT = 1;
const ORDER_TYPE_HARDWARE = 2;
const ORDER_TYPE_PLAN = 3;

const RETURN_TYPE_FIXED = 1;
const RETURN_TYPE_RANDOM = 2;


const PAGE_ABOUT_US=1;
const PAGE_PRIVACY_POLICY=2;
const PAGE_TERMS_OF_SERVICE=3;
const PAGE_COOKIE_POLICY=4;
const PAGE_REFUND_POLICY=5;

const EVENT_TYPE_FREE = 1;
const EVENT_TYPE_PAID = 2;

//employee status
const FULL_TIME = 1;
const PART_TIME = 2;
const CONTRACTUAL = 3;
const REMOTE_WORKER = 4;

//job post status
const JOB_STATUS_PENDING = 0;
const JOB_STATUS_APPROVED = 1;
const JOB_STATUS_CANCELED = 2;

//ALUMNI MEMBER STATUS
const ALUMNI_NON_MEMBER = 0;
const ALUMNI_MEMBER = 1;

//ALUMNI MEMBER STATUS
const TRANSACTION_MEMBERSHIP = 1;
const TRANSACTION_EVENT = 2;
const TRANSACTION_SUBSCRIPTION = 3;


// email templates
const EMAIL_TEMPLATE_PAYMENT_SUCCESS = 1;
const EMAIL_TEMPLATE_PAYMENT_FAILURE = 2;
const EMAIL_TEMPLATE_INVOICE = 3;
const EMAIL_TEMPLATE_SUBSCRIPTION_CANCELLATION = 4;
const EMAIL_TEMPLATE_FORGOT_PASSWORD = 5;
const EMAIL_TEMPLATE_PAYMENT_CANCEL = 6;
const EMAIL_TEMPLATE_EMAIL_VERIFY = 7;
const UNLIMITED = -1;

//Subscription Type
const SUBSCRIPTION_TYPE_MONTHLY=1;
const SUBSCRIPTION_TYPE_YEARLY=2;
const PACKAGE_RULE_EXPIRED = 1;
const PACKAGE_RULE_CUSTOM_DOMAIN = 2;
const PACKAGE_RULE_ALUMNI_LIMIT = 3;
const PACKAGE_RULE_EVENT_LIMIT = 4;

