<?php session_start();
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once '../A1XRXS_sys/xrxs_configuracion/config.php';                               //Configuracion de la plataforma
require_once '../../Legacy/gestion_modular/funciones/Helpers.Functions.Propias.php';      //carga librerias de la plataforma

/**********************************************************************************************************************************/
/*                                                  Area de trabajo                                                               */
/**********************************************************************************************************************************/
//verifica la capa de desarrollo
$whitelist = array( 'localhost', '127.0.0.1', '::1' );
//si estoy en ambiente de desarrollo
if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ){
	$server_site = 'https://localhost/power_engine/sistema_web_busafe_apoderado/';
//si estoy en ambiente de produccion	
}else{
	$server_site = 'https://apoderado.busafe.cl/';		
}
/**********************************************************************************************************************************/
/*                                                Ejecucion de Logica                                                             */
/**********************************************************************************************************************************/
//se cargan componentes
require_once 'vendor/autoload.php';
use Transbank\Webpay\Configuration;
use Transbank\Webpay\Webpay;

//se instancia la transaccion	
$Entorno = 2;
switch ($Entorno) {
    //Pruebas
    case 1:
        $transaction = (new Webpay(Configuration::forTestingWebpayPlusNormal()))
						->getNormalTransaction();
        break;
    //INTEGRACION
    case 2:
        //se crea nueva configuracion				
		$configuration = new Configuration();
		$configuration->setEnvironment("INTEGRACION");
		$configuration->setCommerceCode("35255516");
		$configuration->setWebpayCert(
			"-----BEGIN CERTIFICATE-----\n".
			"MIIDizCCAnOgAwIBAgIJAIXzFTyfjyBkMA0GCSqGSIb3DQEBCwUAMFwxCzAJBgNV\n".
			"BAYTAkNMMQswCQYDVQQIDAJSTTERMA8GA1UEBwwIU2FudGlhZ28xEjAQBgNVBAoM\n".
			"CXRyYW5zYmFuazEMMAoGA1UECwwDUFJEMQswCQYDVQQDDAIxMDAeFw0xODAzMjkx\n".
			"NjA4MjhaFw0yMzAzMjgxNjA4MjhaMFwxCzAJBgNVBAYTAkNMMQswCQYDVQQIDAJS\n".
			"TTERMA8GA1UEBwwIU2FudGlhZ28xEjAQBgNVBAoMCXRyYW5zYmFuazEMMAoGA1UE\n".
			"CwwDUFJEMQswCQYDVQQDDAIxMDCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoC\n".
			"ggEBAKRqDk/pv8GeWnEaTVhfw55fThmqbFZOHEc/Un7oVWP+ExjD0kZ/aAwMJZ3d\n".
			"9hpbBExftjoyJ0AYKJXA2CyLGxRp30LapBa2lMehzdP6tC5nrCYbDFz8r8ZyN/ie\n".
			"4lBQ8GjfONq34cLQfM+tOxyazgDYRnZVD9tvOcqI5bFwFKqpn/yMr9Eya7gTo/OP\n".
			"wyz69sAF8MKr0YN941n6C1Cdrzp6cRftdj83nlI75Ue//rMYih/uQYiht4XWFjAA\n".
			"usoOG/IVVCCHhVQGE/Rp22dAF8JzWYZWCe+ICOKjEzEZPjDBqPoh9O+0eGTFVwn2\n".
			"qZf2iSLDKBOiha1wwzpTiiJV368CAwEAAaNQME4wHQYDVR0OBBYEFDfN1Tlj7wbn\n".
			"JIemBNO1XrUOikQpMB8GA1UdIwQYMBaAFDfN1Tlj7wbnJIemBNO1XrUOikQpMAwG\n".
			"A1UdEwQFMAMBAf8wDQYJKoZIhvcNAQELBQADggEBACzXPSHet7aZrQvMUN03jOqq\n".
			"w37brCWZ+L/+pbdOugVRAQRb2W+Z6gyrJ2BuUuiZLCXpjvXACSpwcSB3JesWs9KE\n".
			"YO8E8ofF7a6ORvi2Mw0vpBbwJLqnci1gVlAj3X8r/VbX2rGbvRy+BJAF769xr43X\n".
			"dtns0JIWwKud0xC3iRPMnewo/75HIblbN3guePfouoR2VgfBmeU72UR8O+OpjwbF\n".
			"vpidobGqTGvZtxRV5axer69WY0rAXRhTSfkvyGTXERCJ3vdsF/v9iNKHhERUnpV6\n".
			"KDrfvgD9uqWH12/89hfsfVN6iRH9UOE+SKoR/jHtvLMhVHpa80HVK1qdlfqUTZo=\n".
			"-----END CERTIFICATE-----\n"
		);
		$configuration->setPrivateKey(
			"-----BEGIN RSA PRIVATE KEY-----\n".
			"MIIEowIBAAKCAQEA0umlxiH4n8Wr1dgxaOjZV13QIRQShSqsGQ6DV3RZxGgUcqkO\n".
			"YSvMVDea5i7vvBTfokeU/ykhVe1niIvjpplm/6qFB0PAsWWQB1hrYQKLgi5NT8fA\n".
			"KAmWcGg7HBFP09l25XnmD2NaXejG8UrgtzvYVAnsKItWrdBweujGCQ8P9uEu1ljS\n".
			"lAxyN/pdFVGn6A0NmxUK3R/996CmxV+ap0qiHYFwHOLSKSiRKpn4vRYywOG0OTf3\n".
			"65jfysE1pGphZH4Bj6lZF1mcuHIM5TE07OEVycrzNmL4YEhfenrFLJwDRXxyjx1N\n".
			"7ehr8dtXXtCvhX+5iBD1Cl8E4gQm1uIcRcdnVQIDAQABAoIBAQCK0Wvh17QrfNBX\n".
			"xJ7ovPFoNn/pdaum6GozZ8D8y8DVq+dhfHHRdSFcgOi7/kKeGWMEDXc85lZhlwsg\n".
			"7Wnd2nPXbOV33ZkzaXR90S2DwUgPW+hYzVFlSMIyo/fbxm0zM5u0+CF7GVp+Gtru\n".
			"L+lt0L7WuV0tZmCbsGiIDTNi/P318BebVqgdViKFWZG3wnEIpz5ztIBv5guegCTT\n".
			"/OYngKXAU3RkZEwD2F8rroIVuMVyusqjyYpiVayRyyzxnkHZ8SQ1lPUt793hjsWR\n".
			"m+tI1sgAyGeq32o3wO7gjYjxBs3CbpNPsl0OHpja3rqAgqJID2G/krCA1HQpDZjA\n".
			"WYzA81chAoGBAPwsbRvBaLv1aQ3NOfwKrBQf1+y+Ph/OTCpbLxr4IZxUvpqyOIQq\n".
			"wDCY1Kw+5XhCZ0tuf8twvNL9yZmweU/ZQjGwrXNFbCTfGPm0uLH+r7htBdK1fz2h\n".
			"JJEUg62Gc5+Bjka2iM0tf7EUN9O7Qgh9/vBsTh8y3GxedtmAOlxZVDFpAoGBANYc\n".
			"8VBgGGXjKIkMrwFlt/YKG9oZUAJ9y9oPY0VG5FZF3FTbUpE5FVYtWtc7Dl1a+vlT\n".
			"bwaQGBl0+P5aoZwiKbpDjJK4hrICEa2KcjohBkRHQPYDokqNmcmVDktzecICbCJZ\n".
			"P+u8gxAkFP4MwHJ3Utzgsd37O3dxHSJuB+fWqB0NAoGAQJXcR/yMJ3+eLWO/kxbk\n".
			"pa7WLZM39AtxJHQAJ4cfjJuDybkVknwkhw3NgmQFf3x6Wi5t2pwAMIXBaXRyTYoW\n".
			"UwWuFtTT8smU6vdnSmcxeCmsESBc+1rXM7UuWHYUDOkwmFnNxcb+aksEVV0jd2tV\n".
			"rRwAEiuDmtnC1MfrqpVSY+kCgYBC1Yv549UZ0LtxdDUYgZDXyzYAcVBJRs0gBxec\n".
			"o1FZILty/Xcbf68KVGP7tSJ5v5GBzCpm6QmswJeMhevWWc+epcE2d0UMQZsVCZc4\n".
			"T+Ct5XQAlwfMr8CmbNGmeagzCCCK5EMQqapbmne3CXH1CQwjiDvdJ7PbR8KpYaE0\n".
			"HAwj7QKBgAHKCvx8GY6WdoNk0z/1j8RMXiEzukLDEA+SRrToams/sQ08NzsR9kZY\n".
			"v34lstk/QgmEAEMFI2BC05sUZNhdcqo+AIPhjAdVST1itFrZub+o8wrsCxZTRQ+g\n".
			"oWWlrbRBYQpOIULkeQV36vjk8ININOp4RVM6hMynSPd6bPFAq21a\n".
			"-----END RSA PRIVATE KEY-----\n"
		);
		$configuration->setPublicCert(
			"-----BEGIN CERTIFICATE-----\n".
			"MIICtDCCAZwCAQAwbzELMAkGA1UEBhMCQ0wxEzARBgNVBAgMClNvbWUtU3RhdGUx\n".
			"ETAPBgNVBAcMCFNBTlRJQUdPMSEwHwYDVQQKDBhJbnRlcm5ldCBXaWRnaXRzIFB0\n".
			"eSBMdGQxFTATBgNVBAMMDDU5NzAzNTI1NTUxNjCCASIwDQYJKoZIhvcNAQEBBQAD\n".
			"ggEPADCCAQoCggEBANLppcYh+J/Fq9XYMWjo2Vdd0CEUEoUqrBkOg1d0WcRoFHKp\n".
			"DmErzFQ3muYu77wU36JHlP8pIVXtZ4iL46aZZv+qhQdDwLFlkAdYa2ECi4IuTU/H\n".
			"wCgJlnBoOxwRT9PZduV55g9jWl3oxvFK4Lc72FQJ7CiLVq3QcHroxgkPD/bhLtZY\n".
			"0pQMcjf6XRVRp+gNDZsVCt0f/fegpsVfmqdKoh2BcBzi0ikokSqZ+L0WMsDhtDk3\n".
			"9+uY38rBNaRqYWR+AY+pWRdZnLhyDOUxNOzhFcnK8zZi+GBIX3p6xSycA0V8co8d\n".
			"Te3oa/HbV17Qr4V/uYgQ9QpfBOIEJtbiHEXHZ1UCAwEAAaAAMA0GCSqGSIb3DQEB\n".
			"CwUAA4IBAQATkoNEldULllyUvwHeBGOcNhaogIe4Zx2ggMr2RChyZ/KaC+78LNIo\n".
			"u30nhWOCwkAUZP3mvU1/jds752Rr22XCFk4YIKr/5EkdhvihXizbcayDsp9t3GhP\n".
			"ujh7sub1O/NOCFC48M4MWbCdWKFHKS+u4jiQsiNU2SkahGNaFKaRU5NDfMYA+E7m\n".
			"dqiys9VtQ0CDwHj7QrCAF4yDTos5leJNfZKZDZR9vdrRqlQzMvZV7HXE9UlCT4OL\n".
			"Lo10popY3IcFIoQIe159me7E/n9rYrIT5jho3d4pp1fBMQpCgEUYeZP8M4WTsJjb\n".
			"CCjpJ9byB3XP9TS3Yix787Vr7BKGoVbC\n".
			"-----END CERTIFICATE-----\n"
		);
		$transaction = (new Webpay($configuration))->getNormalTransaction();
        break;
    //PRODUCCION
    case 3:
        //se crea nueva configuracion				
		$configuration = new Configuration();
		$configuration->setEnvironment("PRODUCCION");
		$configuration->setCommerceCode("35255516");
		$configuration->setWebpayCert(
			"-----BEGIN CERTIFICATE-----\n".
			"MIIDizCCAnOgAwIBAgIJAIXzFTyfjyBkMA0GCSqGSIb3DQEBCwUAMFwxCzAJBgNV\n".
			"BAYTAkNMMQswCQYDVQQIDAJSTTERMA8GA1UEBwwIU2FudGlhZ28xEjAQBgNVBAoM\n".
			"CXRyYW5zYmFuazEMMAoGA1UECwwDUFJEMQswCQYDVQQDDAIxMDAeFw0xODAzMjkx\n".
			"NjA4MjhaFw0yMzAzMjgxNjA4MjhaMFwxCzAJBgNVBAYTAkNMMQswCQYDVQQIDAJS\n".
			"TTERMA8GA1UEBwwIU2FudGlhZ28xEjAQBgNVBAoMCXRyYW5zYmFuazEMMAoGA1UE\n".
			"CwwDUFJEMQswCQYDVQQDDAIxMDCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoC\n".
			"ggEBAKRqDk/pv8GeWnEaTVhfw55fThmqbFZOHEc/Un7oVWP+ExjD0kZ/aAwMJZ3d\n".
			"9hpbBExftjoyJ0AYKJXA2CyLGxRp30LapBa2lMehzdP6tC5nrCYbDFz8r8ZyN/ie\n".
			"4lBQ8GjfONq34cLQfM+tOxyazgDYRnZVD9tvOcqI5bFwFKqpn/yMr9Eya7gTo/OP\n".
			"wyz69sAF8MKr0YN941n6C1Cdrzp6cRftdj83nlI75Ue//rMYih/uQYiht4XWFjAA\n".
			"usoOG/IVVCCHhVQGE/Rp22dAF8JzWYZWCe+ICOKjEzEZPjDBqPoh9O+0eGTFVwn2\n".
			"qZf2iSLDKBOiha1wwzpTiiJV368CAwEAAaNQME4wHQYDVR0OBBYEFDfN1Tlj7wbn\n".
			"JIemBNO1XrUOikQpMB8GA1UdIwQYMBaAFDfN1Tlj7wbnJIemBNO1XrUOikQpMAwG\n".
			"A1UdEwQFMAMBAf8wDQYJKoZIhvcNAQELBQADggEBACzXPSHet7aZrQvMUN03jOqq\n".
			"w37brCWZ+L/+pbdOugVRAQRb2W+Z6gyrJ2BuUuiZLCXpjvXACSpwcSB3JesWs9KE\n".
			"YO8E8ofF7a6ORvi2Mw0vpBbwJLqnci1gVlAj3X8r/VbX2rGbvRy+BJAF769xr43X\n".
			"dtns0JIWwKud0xC3iRPMnewo/75HIblbN3guePfouoR2VgfBmeU72UR8O+OpjwbF\n".
			"vpidobGqTGvZtxRV5axer69WY0rAXRhTSfkvyGTXERCJ3vdsF/v9iNKHhERUnpV6\n".
			"KDrfvgD9uqWH12/89hfsfVN6iRH9UOE+SKoR/jHtvLMhVHpa80HVK1qdlfqUTZo=\n".
			"-----END CERTIFICATE-----\n"
		);
		$configuration->setPrivateKey(
			"-----BEGIN RSA PRIVATE KEY-----\n".
			"MIIEowIBAAKCAQEA0umlxiH4n8Wr1dgxaOjZV13QIRQShSqsGQ6DV3RZxGgUcqkO\n".
			"YSvMVDea5i7vvBTfokeU/ykhVe1niIvjpplm/6qFB0PAsWWQB1hrYQKLgi5NT8fA\n".
			"KAmWcGg7HBFP09l25XnmD2NaXejG8UrgtzvYVAnsKItWrdBweujGCQ8P9uEu1ljS\n".
			"lAxyN/pdFVGn6A0NmxUK3R/996CmxV+ap0qiHYFwHOLSKSiRKpn4vRYywOG0OTf3\n".
			"65jfysE1pGphZH4Bj6lZF1mcuHIM5TE07OEVycrzNmL4YEhfenrFLJwDRXxyjx1N\n".
			"7ehr8dtXXtCvhX+5iBD1Cl8E4gQm1uIcRcdnVQIDAQABAoIBAQCK0Wvh17QrfNBX\n".
			"xJ7ovPFoNn/pdaum6GozZ8D8y8DVq+dhfHHRdSFcgOi7/kKeGWMEDXc85lZhlwsg\n".
			"7Wnd2nPXbOV33ZkzaXR90S2DwUgPW+hYzVFlSMIyo/fbxm0zM5u0+CF7GVp+Gtru\n".
			"L+lt0L7WuV0tZmCbsGiIDTNi/P318BebVqgdViKFWZG3wnEIpz5ztIBv5guegCTT\n".
			"/OYngKXAU3RkZEwD2F8rroIVuMVyusqjyYpiVayRyyzxnkHZ8SQ1lPUt793hjsWR\n".
			"m+tI1sgAyGeq32o3wO7gjYjxBs3CbpNPsl0OHpja3rqAgqJID2G/krCA1HQpDZjA\n".
			"WYzA81chAoGBAPwsbRvBaLv1aQ3NOfwKrBQf1+y+Ph/OTCpbLxr4IZxUvpqyOIQq\n".
			"wDCY1Kw+5XhCZ0tuf8twvNL9yZmweU/ZQjGwrXNFbCTfGPm0uLH+r7htBdK1fz2h\n".
			"JJEUg62Gc5+Bjka2iM0tf7EUN9O7Qgh9/vBsTh8y3GxedtmAOlxZVDFpAoGBANYc\n".
			"8VBgGGXjKIkMrwFlt/YKG9oZUAJ9y9oPY0VG5FZF3FTbUpE5FVYtWtc7Dl1a+vlT\n".
			"bwaQGBl0+P5aoZwiKbpDjJK4hrICEa2KcjohBkRHQPYDokqNmcmVDktzecICbCJZ\n".
			"P+u8gxAkFP4MwHJ3Utzgsd37O3dxHSJuB+fWqB0NAoGAQJXcR/yMJ3+eLWO/kxbk\n".
			"pa7WLZM39AtxJHQAJ4cfjJuDybkVknwkhw3NgmQFf3x6Wi5t2pwAMIXBaXRyTYoW\n".
			"UwWuFtTT8smU6vdnSmcxeCmsESBc+1rXM7UuWHYUDOkwmFnNxcb+aksEVV0jd2tV\n".
			"rRwAEiuDmtnC1MfrqpVSY+kCgYBC1Yv549UZ0LtxdDUYgZDXyzYAcVBJRs0gBxec\n".
			"o1FZILty/Xcbf68KVGP7tSJ5v5GBzCpm6QmswJeMhevWWc+epcE2d0UMQZsVCZc4\n".
			"T+Ct5XQAlwfMr8CmbNGmeagzCCCK5EMQqapbmne3CXH1CQwjiDvdJ7PbR8KpYaE0\n".
			"HAwj7QKBgAHKCvx8GY6WdoNk0z/1j8RMXiEzukLDEA+SRrToams/sQ08NzsR9kZY\n".
			"v34lstk/QgmEAEMFI2BC05sUZNhdcqo+AIPhjAdVST1itFrZub+o8wrsCxZTRQ+g\n".
			"oWWlrbRBYQpOIULkeQV36vjk8ININOp4RVM6hMynSPd6bPFAq21a\n".
			"-----END RSA PRIVATE KEY-----\n"
		);
		$configuration->setPublicCert(
			"-----BEGIN CERTIFICATE-----\n".
			"MIICtDCCAZwCAQAwbzELMAkGA1UEBhMCQ0wxEzARBgNVBAgMClNvbWUtU3RhdGUx\n".
			"ETAPBgNVBAcMCFNBTlRJQUdPMSEwHwYDVQQKDBhJbnRlcm5ldCBXaWRnaXRzIFB0\n".
			"eSBMdGQxFTATBgNVBAMMDDU5NzAzNTI1NTUxNjCCASIwDQYJKoZIhvcNAQEBBQAD\n".
			"ggEPADCCAQoCggEBANLppcYh+J/Fq9XYMWjo2Vdd0CEUEoUqrBkOg1d0WcRoFHKp\n".
			"DmErzFQ3muYu77wU36JHlP8pIVXtZ4iL46aZZv+qhQdDwLFlkAdYa2ECi4IuTU/H\n".
			"wCgJlnBoOxwRT9PZduV55g9jWl3oxvFK4Lc72FQJ7CiLVq3QcHroxgkPD/bhLtZY\n".
			"0pQMcjf6XRVRp+gNDZsVCt0f/fegpsVfmqdKoh2BcBzi0ikokSqZ+L0WMsDhtDk3\n".
			"9+uY38rBNaRqYWR+AY+pWRdZnLhyDOUxNOzhFcnK8zZi+GBIX3p6xSycA0V8co8d\n".
			"Te3oa/HbV17Qr4V/uYgQ9QpfBOIEJtbiHEXHZ1UCAwEAAaAAMA0GCSqGSIb3DQEB\n".
			"CwUAA4IBAQATkoNEldULllyUvwHeBGOcNhaogIe4Zx2ggMr2RChyZ/KaC+78LNIo\n".
			"u30nhWOCwkAUZP3mvU1/jds752Rr22XCFk4YIKr/5EkdhvihXizbcayDsp9t3GhP\n".
			"ujh7sub1O/NOCFC48M4MWbCdWKFHKS+u4jiQsiNU2SkahGNaFKaRU5NDfMYA+E7m\n".
			"dqiys9VtQ0CDwHj7QrCAF4yDTos5leJNfZKZDZR9vdrRqlQzMvZV7HXE9UlCT4OL\n".
			"Lo10popY3IcFIoQIe159me7E/n9rYrIT5jho3d4pp1fBMQpCgEUYeZP8M4WTsJjb\n".
			"CCjpJ9byB3XP9TS3Yix787Vr7BKGoVbC\n".
			"-----END CERTIFICATE-----\n"
		);
		$transaction = (new Webpay($configuration))->getNormalTransaction();
        break;
}
								
//se definen los datos								
$amount = $_SESSION['trbnk']['montoPago'];
// Identificador que será retornado en el callback de resultado:
$sessionId = $_SESSION['trbnk']['buyOrder'];
// Identificador único de orden de compra:
$buyOrder    = $_SESSION['trbnk']['buyOrder'];
$returnUrl   = $server_site.'transbank/cambio_plan_confirmacion.php';
$finalUrl    = $server_site.'principal_contratos.php?confirmacion=true';
$initResult  = $transaction->initTransaction($amount, $buyOrder, $sessionId, $returnUrl, $finalUrl);

//Respuesta por parte del servidor
$formAction  = $initResult->url;
$tokenWs     = $initResult->token;


?>
<style>
	body {
		background-color: #F3C500;
		background-image: url("../img/Fondo.jpg");
		background-size: 100%;
	}
</style>

<form action="<?php echo$formAction; ?>" method="post" id="init-form" >
	<input type="hidden" name="token_ws"  value="<?php echo $tokenWs; ?>" />
</form>

<script>
	//se ejecuta formulario
	document.getElementById('init-form').submit();
</script>


