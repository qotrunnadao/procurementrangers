<?php

use App\DocumentAttachment;
use Google\Cloud\Storage\StorageClient;
use hisorange\BrowserDetect\Parser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Globally available helper methods.
 *
 * LICENSE: This product includes software developed at
 * the PT MANDALA DWIPANTARA PROTEKSI. (http://mandaladwipantara.co.id/).
 *
 * @category   MVC Model
 *
 * @author     DS <tech@mandaladwipantara.co.id>
 * @copyright  PT MANDALA DWIPANTARA PROTEKSI
 * @license    PT MANDALA DWIPANTARA PROTEKSI
 *
 * @version    1.2
 *
 * @link       http://mandaladwipantara.co.id
 */

/**
 *  Convert dashed string into camelcase string
 *
 *  @param string string
 *
 *  @return string converted string
 */

/**
 *  @package: https://github.com/hisorange/browser-detect
 *
 *  Get Browser Details using the Package
 *
 *  @return collection of browser details
 */
function get_browser_details()
{
    $browser = new Parser(null, null, [
        'cache' => [
            'interval' => 86400 // This will overide the default configuration.
        ]
    ]);

    $result = $browser->detect();
    return $result;
}

function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
{
    $str = ucwords(str_replace('-', ' ', $string));

    if (!$capitalizeFirstCharacter) {
        $str[0] = strtolower($str[0]);
    }

    return $str;
}


/**
 *  Convert underscored string into camelcase string
 *
 *  @param string string
 *
 *  @return string converted string
 */

function underscoreToCamelCase($string, $capitalizeFirstCharacter = false)
{
    $str = ucfirst(str_replace('_', ' ', $string));

    return $str;
}

/**
 * Get full table name by adding the DB prefix.
 *
 * @param string table name
 *
 * @return string fulle table name with prefix
 */
function table($name)
{
    return \DB::getTablePrefix() . $name;
}

/**
 * Break an array into smaller batches (arrays).
 *
 * @param array original array
 * @param int batch size
 * @param bool whether or not to skip the first header line
 * @param callback function
 */
function each_batch($array, $batchSize, $skipHeader, $callback)
{
    $batch = [];
    foreach ($array as $i => $value) {
        // skip the header
        if ($i == 0 && $skipHeader) {
            continue;
        }

        if ($i % $batchSize == 0) {
            $callback($batch);
            $batch = [];
        }
        $batch[] = $value;
    }

    // the last callback
    if (sizeof($batch) > 0) {
        $callback($batch);
    }
}

/**
 * Count the total number of line of a given file without loading the entire file.
 * This is effective for large file.
 *
 * @param string file path
 *
 * @return int line count
 */
function line_count($path)
{
    $file = new \SplFileObject($path, 'r');
    $file->seek(PHP_INT_MAX);

    return $file->key() + 1;
}

/**
 * Join filesystem path strings.
 *
 * @param * parts of the path
 *
 * @return string a full path
 */
function join_paths()
{
    $paths = array();
    foreach (func_get_args() as $arg) {
        if ($arg !== '') {
            $paths[] = $arg;
        }
    }

    return preg_replace('#/+#', '/', implode('/', $paths));
}

/**
 * Join URL parts.
 *
 * @param * parts of the URL. Note that the first part should be something like http:// or http://host.name
 *
 * @return string a full URL
 */
function join_url()
{
    $paths = array();
    foreach (func_get_args() as $arg) {
        if ($arg !== '') {
            $paths[] = $arg;
        }
    }

    return preg_replace('#(?<=[^:])/+#', '/', implode('/', $paths));
}

/**
 * Get unique array based on user defined condition.
 *
 * @param array original array
 *
 * @return array unique array
 */
function array_unique_by($array, $callback)
{
    $result = [];
    foreach ($array as $value) {
        $key = $callback($value);
        $result[$key] = $value;
    }

    return array_values($result);
}

/**
 * Get UTC offset of a particular time zone.
 *
 * @param string timezone
 *
 * @return string UTC offset (+02:00 for example)
 */
function utc_offset($timezone)
{
    $offset = \Carbon\Carbon::now($timezone)->offsetHours - \Carbon\Carbon::now('UTC')->offsetHours;

    return sprintf("%+'03d:00", $offset);
}

/**
 * Get Database UTC offset.
 *
 * @return string UTC offset (+02:00 for example)
 */
function db_utc_offset()
{
    $zone = DB::select("SELECT TIME_FORMAT(TIMEDIFF(NOW(), UTC_TIMESTAMP), '%H:%i') AS zone")[0]->zone;

    if (!preg_match('/^-/', $zone)) {
        $zone = "+$zone";
    }

    return $zone;
}

/**
 * Check if exec() function is available.
 *
 * @return bool
 */
function exec_enabled()
{
    try {
        // make a small test
        exec('ls');

        return function_exists('exec') && !in_array('exec', array_map('trim', explode(', ', ini_get('disable_functions'))));
    } catch (\Exception $ex) {
        return false;
    }
}

function reset_app_url($force = false)
{ // replace if already exists
    // update .env file, set app_url to current host url

    // get .env file path
    $path = base_path('.env');
    $raw = preg_split('/[\r\n]+/', file_get_contents($path));

    // read from .env, load into $settings as [ key1 => value1, key2 => value2, etc. ]
    $settings = [];
    foreach ($raw as $e) {
        preg_match('/^(?<key>[A-Z0-9_]+)=(?<value>.*)/', $e, $matched);

        if (array_key_exists('key', $matched) && array_key_exists('value', $matched)) {
            $settings[$matched['key']] = $matched['value'];
        }
    }

    // add APP_URL setting if not exists
    if (!array_key_exists('APP_URL', $settings)) {
        $settings['APP_URL'] = url('/');
    } elseif ($force) {
        $settings['APP_URL'] = url('/');
    }

    // Write back to .env file
    $file = fopen($path, 'w');
    foreach ($settings as $key => $value) {
        fwrite($file, "{$key}=$value\n");
    }
    fclose($file);
}

/**
 * Run artisan config cache.
 *
 * @return bool
 */
function artisan_config_cache()
{
    // Artisan config:cache generate the following two files
    // Since config:cache runs in the background
    // to determine if it is done, we just check if the files modified time have been changed
    $files = ['bootstrap/cache/config.php', 'bootstrap/cache/services.php'];

    // get the last modified time of the files
    $last = 0;
    foreach ($files as $file) {
        $path = base_path($file);
        if (file_exists($path)) {
            if (filemtime($path) > $last) {
                $last = filemtime($path);
            }
        }
    }

    // prepare to run
    $timeout = 5;
    $start = time();

    // actually call the Artisan command
    \Artisan::call('config:cache');

    // Check if Artisan call is done
    while (true) {
        // just finish if timeout
        if (time() - $start >= $timeout) {
            echo "Timeout\n";
            break;
        }

        // if any file is still missing, keep waiting
        // if any file is not updated, keep waiting
        // @todo: services.php file keeps unchanged after artisan config:cache
        foreach ($files as $file) {
            $path = base_path($file);
            if (!file_exists($path)) {
                sleep(1);
                continue;
            } else {
                if (filemtime($path) == $last) {
                    sleep(1);
                    continue;
                }
            }
        }

        // just wait another extra 3 seconds before finishing
        sleep(3);
        break;
    }
}

/**
 * Run artisan migrate.
 *
 * @return bool
 */
function artisan_migrate()
{
    \Artisan::call('migrate', ['--force' => true]);
}

/**
 * Run artisan storage link.
 *
 * @return bool
 */
function artisan_storage_link()
{
    \Artisan::call('storage:link');
}

/**
 * Run artisan clean up.
 *
 * @return bool
 */
function artisan_clear()
{
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
}

/**
 * Check if site is in demo mod.
 *
 * @return bool
 */
function isSiteDemo()
{
    return config('app.demo');
}

/**
 * Get language code.
 *
 * @return string
 */
function language_code()
{
    // Generate info
    $user = \Auth::user();

    $default_language = \Acelle\Model\Language::find(\Acelle\Model\Setting::get('default_language'));

    if (isset($_COOKIE['last_language_code'])) {
        $language_code = $_COOKIE['last_language_code'];
    } elseif (is_object($default_language)) {
        $language_code = $default_language->code;
    } else {
        $language_code = 'en';
    }

    return $language_code;
}

/**
 * Format a number as percentage.
 *
 * @return string
 */
function number_to_percentage($number, $precision = 2)
{
    if (!is_numeric($number)) {
        return $number;
    }

    return sprintf("%.{$precision}f%%", $number * 100);
}

/**
 * Format a number with delimiter.
 *
 * @return string
 */
function number_with_delimiter($number, $precision = 0, $seperator = ',')
{
    if (!is_numeric($number)) {
        return $number;
    }

    return number_format($number, $precision, '.', $seperator);
}

/**
 * Get User's IP
 *
 * @return an array
 */
// Function to get the client IP address
function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
/**
 * Function to convert IP address to IP number (IPv6).
 *
 * @return string
 */
function Dot2LongIPv6($IPaddr)
{
    $int = inet_pton($IPaddr);
    $bits = 15;
    $ipv6long = 0;
    while ($bits >= 0) {
        $bin = sprintf('%08b', (ord($int[$bits])));
        if ($ipv6long) {
            $ipv6long = $bin . $ipv6long;
        } else {
            $ipv6long = $bin;
        }
        --$bits;
    }
    $ipv6long = gmp_strval(gmp_init($ipv6long, 2), 10);

    return $ipv6long;
}

/**
 * Distinct count helper for performance.
 *
 * @return int
 */
function distinctCount($builder, $column = null, $method = 'group')
{
    $q = clone $builder;
    /*
     * There are 2 options to COUNT DISTINCT
     *   1. Use DISTINCT
     *   2. Use GROUP BY
     * Normally GROUP BY yields better performance (for example: 500,000 records, DISTINCT -> 7 seconds, GROUP BY -> 1.9 seconds)
     **/

    if (is_null($column)) {
        // just count it
    } elseif ($method == 'group') {
        $q->groupBy($column)->select($column);
    } elseif ($method == 'distinct') {
        $q->select($column)->distinct();
    }

    // Result
    $count = \DB::table(\DB::raw("({$q->toSql()}) as sub"))
        ->addBinding($q->getBindings()) // you need to get underlying Query Builder
        ->count();

    return $count;
}

/**
 * Measure execution time of a script.
 *
 * @return float execution time
 */
function measure2($callback, $tests = 5)
{
    $results = [];

    for ($i = 0; $i <= $tests; $i += 1) {
        $start = microtime(true);
        $callback();
        $time = microtime(true) - $start;
        $results[] = $time;
    }
    $agv = array_sum($results) / count($results);
    echo "$agv\n";

    return $agv;
}

/**
 * Check if function is enabled.
 *
 * @return bool
 */
function func_enabled($name)
{
    try {
        $disabled = explode(',', ini_get('disable_functions'));

        return !in_array($name, $disabled);
    } catch (\Exception $ex) {
        return false;
    }
}

/**
 * Get the current application version.
 *
 * @return string version
 */
function app_version()
{
    return trim(file_get_contents(base_path('VERSION')));
}

/**
 * Extract email from a string
 * For example: get abc@mail.com from "My Name <abc@mail.com>".
 *
 * @return string version
 */
function extract_email($str)
{
    preg_match("/(?<email>[-0-9a-zA-Z\.+_]+@[-0-9a-zA-Z\.+_]+\.[a-zA-Z]+)/", $str, $matched);
    if (array_key_exists('email', $matched)) {
        return $matched['email'];
    } else {
        return;
    }
}

/**
 * Extract name from a string
 * For example: get abc@mail.com from "My Name <abc@mail.com>".
 *
 * @return string version
 */
function extract_name($str)
{
    $parts = explode('<', $str);
    if (count($parts) > 1) {
        return trim($parts[0]);
    }
    $parts = explode('@', extract_email($str));

    return $parts[0];
}

/**
 * Extract domain from an email
 * For example: get mail.com from "My Name <abc@mail.com>".
 *
 * @return string version
 */
function extract_domain($email)
{
    $email = extract_email($email);
    $domain = substr(strrchr($email, '@'), 1);

    return $domain;
}

/**
 * Doublequote a string.
 *
 * @return string
 */
function doublequote($str)
{
    return sprintf('"%s"', preg_replace('/^"+|"+$/', '', $str));
}

function jsonGet($array, $path)
{
    $jsonObject = new \JsonPath\JsonObject($array);
    $result = $jsonObject->get($path)[0];

    return $result;
}

/**
 * Format price.
 *
 * @param string
 *
 * @return string
 */
function format_number($number)
{
    if (is_numeric($number) && floor($number) != $number) {
        return number_format($number, 2, trans('messages.dec_point'), trans('messages.thousands_sep'));
    } elseif (is_numeric($number)) {
        return number_format($number, 0, trans('messages.dec_point'), trans('messages.thousands_sep'));
    } else {
        return $number;
    }
}
/**
 * Format price.
 *
 * @param string
 *
 * @return string
 */
function format_price($price, $format = '{PRICE}')
{
    return str_replace('{PRICE}', format_number($price), $format);
}

/**
 * Check if the app is initiated.
 *
 * @return bool
 */
function isInitiated()
{
    return file_exists(storage_path('app/installed'));
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}


/**
 * Check if string is email.
 *
 * @return object
 */
function checkEmail($email)
{
    $find1 = strpos($email, '@');
    $find2 = strpos($email, '.');
    return ($find1 !== false && $find2 !== false && $find2 > $find1);
}

/**
 * clean money format by replacing all comas
 *
 * @return number
 */
function cleanMoneyFormat($number)
{
    return str_replace(',', '', $number);
}

/**
 * convert date format from d/m/Y to Y-m-d
 *
 * @return date
 */
function cleanDateFormat($date)
{
    return date('Y-m-d', strtotime(str_replace('/', '-', $date)));
}

/**
 * convert date format from d/m/Y to Y-m-d
 *
 * @return date
 */
function dateFormat($date)
{
    return date('d/m/Y', strtotime($date));
}

/**
 * convert integer to roman
 *
 * @return string
 */
function integerToRoman($integer)
{
    // Convert the integer into an integer (just to make sure)
    $integer = intval($integer);
    $result = '';

    // Create a lookup array that contains all of the Roman numerals.
    $lookup = array(
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1
    );

    foreach ($lookup as $roman => $value) {
        // Determine the number of matches
        $matches = intval($integer / $value);

        // Add the same number of characters to the string
        $result .= str_repeat($roman, $matches);

        // Set the integer to be the remainder of the integer and the value
        $integer = $integer % $value;
    }

    // The Roman numeral should be built, return it
    return $result;
}

function ecd64($val)
{
    return base64_encode($val);
}

function dcd64($val)
{
    return base64_decode($val);
}

function invertNumber($val)
{
    $val = doubleval($val);
    return $val != 0 ? $val * -1 : 0;
}

function formatOrdinal($integer)
{
    $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
    $no = $numberFormatter->format($integer);

    return $no;
}

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " Belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " Puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " Seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " Seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " Ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " Juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " Milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " Trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "Minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}

function simbol_currency($code)
{
    if ($code == "USD") $simbol = "$ ";
    elseif ($code == "IDR") $simbol = "Rp. ";
    elseif ($code == "ALL") $simbol = "Lek ";
    elseif ($code == "AFN") $simbol = "؋ ";
    elseif ($code == "ARS") $simbol = "$ ";
    elseif ($code == "AWG") $simbol = "ƒ ";
    elseif ($code == "AUD") $simbol = "$ ";
    elseif ($code == "AZN") $simbol = "₼ ";
    elseif ($code == "BSD") $simbol = "$ ";
    elseif ($code == "IDR") $simbol = "$ ";
    elseif ($code == "BBD") $simbol = "ALL ";
    elseif ($code == "BYN") $simbol = "Br ";
    elseif ($code == "BZD") $simbol = "BZ$ ";
    elseif ($code == "BMD") $simbol = "$ ";
    elseif ($code == "SGD") $simbol = "$ ";
    elseif ($code == "MYR") $simbol = "RM ";
    elseif ($code == "SAR") $simbol = "﷼ ";
    else $simbol = "";

    return $simbol;
}

function uploadToCloud($bucketname, $filepath, $filename, $foldername)
{
    try {
        $storage = new StorageClient([
            'keyFilePath' =>  './cloud_storage.json',
        ]);

        $bucket = $storage->bucket($bucketname);

        $object = $bucket->upload(
            fopen($filepath, 'r'),
            ['predefinedAcl' => 'publicRead'],
            ['name' => $foldername . '/' . $filename]
        );
        $data = [
            'status' => 201,
            'message' => 'Successfully stored!',
            'url' => 'https://storage.googleapis.com/' . $bucketname . '/' . $filename,
        ];
        return $data;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function storeDocumentAttachment($source, $source_id, $cid_upload, $name, $url, $keterangan, $user)
{
    return DocumentAttachment::create([
        'source' => $source,
        'source_id' => $source_id,
        'cid_upload' => $cid_upload,
        'name' => $name,
        'url' => $url,
        'keterangan' => $keterangan,
        'user_id' => $user,
    ]);
}

function uploadDocumentAttachment($bucketname, $files)
{
    $datas = [];
    for ($i = 0; $i < count($files); $i++) {
        $filenamewithextension = $files[$i]->getClientOriginalName();

        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        $extension = $files[$i]->getClientOriginalExtension();

        $filenametostore = $filename . '_' . uniqid() . '.' . $extension;

        Storage::put('public/tempUpload/' . $filenametostore, fopen($files[$i], 'r+'));

        $filepath = storage_path('app/public/tempUpload/' . $filenametostore);

        $data = uploadToCloud(
            $bucketname,
            $filepath,
            $filenametostore,
            'lampiran'
        );

        Storage::delete('public/tempUpload/' . $filenametostore);

        array_push($datas, (object)['filename' => $filename, 'url' => $data['url']]);
    }
    return $datas;
}

function duplicateName($name)
{
    $cnama = preg_replace('/[^a-z]/', '', strtolower($name));
    $cnama = str_replace('tj', 'c', $cnama);
    $cnama = str_replace('th', 't', $cnama);
    $cnama = str_replace('kh', 'h', $cnama);
    $cnama = str_replace('ch', 'h', $cnama);
    $cnama = str_replace('dj', 'j', $cnama);
    $cnama = str_replace('j', 'y', $cnama);
    $cnama = str_replace('y', 'i', $cnama);
    $cnama = str_replace('oe', 'u', $cnama);
    $cnama = str_replace('dh', 'd', $cnama);
    $cnama = str_replace('z', 's', $cnama);
    $cnama = str_replace('er', 'r', $cnama);
    $cnama = str_replace('ua', 'w', $cnama);
    $cnama = str_replace('moh', 'muh', $cnama);
    $cnama = str_replace('aa', 'a', $cnama);
    $cnama = str_replace('bb', 'b', $cnama);
    $cnama = str_replace('cc', 'c', $cnama);
    $cnama = str_replace('dd', 'd', $cnama);
    $cnama = str_replace('ee', 'e', $cnama);
    $cnama = str_replace('ff', 'f', $cnama);
    $cnama = str_replace('gg', 'g', $cnama);
    $cnama = str_replace('hh', 'h', $cnama);
    $cnama = str_replace('ii', 'i', $cnama);
    $cnama = str_replace('kk', 'k', $cnama);
    $cnama = str_replace('ll', 'l', $cnama);
    $cnama = str_replace('mm', 'm', $cnama);
    $cnama = str_replace('nn', 'n', $cnama);
    $cnama = str_replace('oo', 'o', $cnama);
    $cnama = str_replace('pp', 'p', $cnama);
    $cnama = str_replace('qq', 'q', $cnama);
    $cnama = str_replace('rr', 'r', $cnama);
    $cnama = str_replace('ss', 's', $cnama);
    $cnama = str_replace('tt', 't', $cnama);
    $cnama = str_replace('uu', 'u', $cnama);
    $cnama = str_replace('vv', 'v', $cnama);
    $cnama = str_replace('ww', 'w', $cnama);
    $cnama = str_replace('xx', 'x', $cnama);

    return $cnama;
}
