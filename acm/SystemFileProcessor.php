<?php

/**
 * @SystemFileProcessor
 * 
 * here all system files will be loaded
 *
 */

//some PHP Functions
require_once __DIR__ . "/SysModules/PHP_Modules/DateTime.php";
require_once __DIR__ . "/SysModules/PHP_Modules/WorkingOnDates.php";
require_once __DIR__ . "/SysModules/PHP_Modules/EncDec.php";
require_once __DIR__ . "/SysModules/PHP_Modules/UrlActivity.php";
require_once __DIR__ . "/SysModules/PHP_Modules/GetIPAddress.php";
require_once __DIR__ . "/SysModules/PHP_Modules/DeviceType.php";
require_once __DIR__ . "/SysModules/PHP_Modules/DeviceInfo.php";
require_once __DIR__ . "/SysModules/PHP_Modules/DataActivity.php";
require_once __DIR__ . "/SysModules/PHP_Modules/DataReturns.php";
require_once __DIR__ . "/SysModules/PHP_Modules/FormValidations.php";
require_once __DIR__ . "/SysModules/PHP_Modules/DeveloperConstants.php";
require_once __DIR__ . "/SysModules/PHP_Modules/DirHandler.php";
require_once __DIR__ . "/SysModules/PHP_Modules/SessionDataHandler.php";
require_once __DIR__ . "/SysModules/PHP_Modules/PhpUtilityFunctions.php";
require_once __DIR__ . "/SysModules/PHP_Modules/PriceAndCharges.php";
require_once __DIR__ . "/SysModules/PHP_Modules/SelectOptions.php";

//Some File Handling Functions
require_once __DIR__ . "/SysModules/FILE_Modules/GetFilesFromDirectory.php";
require_once __DIR__ . "/SysModules/FILE_Modules/UploadHandler.php";
require_once __DIR__ . "/SysModules/FILE_Modules/OtherFunctions.php";

//Form Validation + Message Handling Functions
require_once __DIR__ . "/SysModules/PROCESS_Modules/FormRequestHandler.php";
require_once __DIR__ . "/SysModules/PROCESS_Modules/FormRequestValidator.php";
require_once __DIR__ . "/SysModules/PROCESS_Modules/Handler.php";
require_once __DIR__ . "/SysModules/PROCESS_Modules/RequestHandler.php";

//CRUD OPERATION Handlers
require_once __DIR__ . "/SysModules/CRUD_Modules/Sql.php";
require_once __DIR__ . "/SysModules/CRUD_Modules/Select.php";
require_once __DIR__ . "/SysModules/CRUD_Modules/Checker.php";
require_once __DIR__ . "/SysModules/CRUD_Modules/Insert.php";
require_once __DIR__ . "/SysModules/CRUD_Modules/Update.php";
require_once __DIR__ . "/SysModules/CRUD_Modules/Delete.php";
require_once __DIR__ . "/SysModules/CRUD_Modules/Suggest.php";
require_once __DIR__ . "/SysModules/CRUD_Modules/SysValues.php";
require_once __DIR__ . "/SysModules/CRUD_Modules/DBOperations.php";
require_once __DIR__ . "/SysModules/CRUD_Modules/CreateTables.php";
require_once __DIR__ . "/SysModules/CRUD_Modules/AppLogsDB.php";

//HTML Functions + Forms
require_once __DIR__ . "/SysModules/HTML_Modules/Form.php";
require_once __DIR__ . "/SysModules/HTML_Modules/HTMLFunctions.php";
require_once __DIR__ . "/SysModules/HTML_Modules/Calendar.php";

//payment modules
require_once  __DIR__ . "/SysModules/PAYMENT_Modules/Payments.php";

//mails modules
require_once __DIR__ . "/SysModules/MAIL_Modules/MailConfigs.php";
require_once  __DIR__ . "/SysModules/MAIL_Modules/Mail.php";

//sms modules
require_once  __DIR__ . "/SysModules/SMS_Modules/SMS.php";

//All Data collection modules
require_once __DIR__ . "/SysModules/DATA_COLLECTION_Modules/AllBankLists.php";
require_once __DIR__ . "/SysModules/DATA_COLLECTION_Modules/AllCountryNames.php";
require_once __DIR__ . "/SysModules/DATA_COLLECTION_Modules/AllCurrencyTypes.php";
require_once __DIR__ . "/SysModules/DATA_COLLECTION_Modules/AllIndianStates.php";
require_once __DIR__ . "/SysModules/DATA_COLLECTION_Modules/AllFontAwesomeIcons.php";
require_once __DIR__ . "/SysModules/DATA_COLLECTION_Modules/AllCountryPhoneCodes.php";
require_once __DIR__ . "/SysModules/DATA_COLLECTION_Modules/UsersUtilityValues.php";
