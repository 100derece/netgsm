# Netgsm Laravel Package

## Installation

Install package with **composer**

```
composer require yuzderece/netgsm
```

## Configuration

Add Netgsm API information to `.env` file

```
NETGSM_URL=https://api.netgsm.com.tr
NETGSM_USERNAME=
NETGSM_PASSWORD=
NETGSM_HEADER=
```

`NETGSM_URL` is API base url of netgsm. `NETGSM_USERNAME` and `NETGSM_PASSWORD` is authentication information of netgsm. `NETGSM_HEADER` is default header of sms messages.

You can also publish config file.

```
php artisan vendor:publish --provider="Yuzderece\Netgsm\NetgsmServiceProvider"
```

## Usage

Send sms to one number

```
Netgsm::sendSms("50xxxxxxxx", "Message content");
```

You can also specify options. Like header and startDate

```
Netgsm::sendSms($number, $message, $header = null, $startDate = null, $endDate = null, $lang = null);
```

Send sms to multiple numbers

```
Netgsm::sendSms(["50xxxxxxxx", "50xxxxxxxx"], "Message Content");
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
