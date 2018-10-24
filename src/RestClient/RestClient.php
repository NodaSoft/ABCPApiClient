<?php

namespace NS\ABCPApi\RestClient;

/**
 * ABCP TecDoc API Web-service REST-Client.
 */
class RestClient
{
    /**
     * Содержит информацию по последнему выполненому запросу.
     *
     * @var array
     */
    private $requestInfo;

    /**
     * Отправляет запрос.
     *
     * @param Request $request
     * @return Response|NULL
     * @throws \Exception
     */
    public function send(Request $request)
    {
        $response = null;

        $curlHandle = curl_init();
        $requestMethod = $request->getMethod();
        try {
            switch (strtoupper($requestMethod)) {
                case 'GET':
                    $response = $this->executeGet($curlHandle, $request);
                    break;
                case 'POST':
                    $response = $this->executePost($curlHandle, $request);
                    break;
                case 'PUT':
                    $response = $this->executePut($curlHandle, $request);
                    break;
                case 'DELETE':
                    $response = $this->executeDelete($curlHandle, $request);
                    break;
                default:
                    throw new \InvalidArgumentException("Current verb ({$requestMethod}) is an invalid REST verb.");
            }
        } catch (\Exception $e) {
            curl_close($curlHandle);
            throw $e;
        }
        curl_close($curlHandle);

        return $response;
    }

    /**
     * Выполняет запрос методом GET
     *
     * @param $curlHandle
     * @param Request $request
     * @return Response
     */
    private function executeGet($curlHandle, Request $request)
    {
        $uri = strpos($request->getOperation(), '/') === 0 ? $request->getOperation() : '/' . $request->getOperation();
        $getUrl = $this->buildGetUrl($request->getServiceUrl() . $uri, $request->getParameters());
        curl_setopt($curlHandle, CURLOPT_URL, $getUrl);

        return $this->doExecute($curlHandle, $request);
    }

    /**
     * Формирует url строку для GET запроса.
     *
     * @param $url
     * @param array|NULL $parameters
     * @return string
     */
    private function buildGetUrl($url, $parameters = null)
    {
        $parametersAsString = '';
        if (!empty($parameters)) {
            $parametersAsString = http_build_query($parameters, '', '&');
        }

        return $url . '?' . $parametersAsString;
    }

    /**
     * Выполняет ранее сформированный запрос. Возвращает объект типа Response.
     *
     * @param $curlHandle
     * @param Request $request
     * @return Response
     */
    private function doExecute($curlHandle, Request $request)
    {
        curl_setopt($curlHandle, CURLINFO_HEADER_OUT, true);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 120);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HEADER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, [
            'Accept: ' . $request->getHttpAccept(),
            'Content-Type: ' . $request->getContentType(),
        ]);
        $res = curl_exec($curlHandle);
        $this->requestInfo = $info = curl_getinfo($curlHandle);
        $response = new Response();
        $response->setStatus($info['http_code']);
        if (false !== $res) {
            $response->setHeaders(substr($res, 0, $info['header_size']));
            if ($info['download_content_length'] > 0) {
                $response->setBody(substr($res, -$info['download_content_length']));
            } else {
                $response->setBody(substr($res, $info['header_size']));
            }
        }

        return $response;
    }

    /**
     * Выполяняет запрос методом POST
     *
     * @param $curlHandle
     * @param Request $request
     * @return Response
     */
    private function executePost($curlHandle, Request $request)
    {
        $uri = strpos($request->getOperation(), '/') === 0 ? $request->getOperation() : '/' . $request->getOperation();
        curl_setopt($curlHandle, CURLOPT_URL, $request->getServiceUrl() . $uri);
        $requestVars = $request->getParameters();
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query(self::convertArray($requestVars)));

        return $this->doExecute($curlHandle, $request);
    }

    /**
     * Преобразовывает многоуровневый массив к одноуровневому. Поддержка загрузки файлов.
     *
     * @param $data
     * @param string $path
     * @return array
     */
    private static function convertArray($data, $path = '')
    {
        $out = [];
        if (is_array($data)) {
            foreach ($data as $k => $value) {
                $path1 = $path ? $path . "[$k]" : $k;
                $result = self::convertArray($value, $path1);
                if (is_array($result)) {
                    foreach ($result as $k2 => $val2) {
                        $out[$k2] = $val2;
                    }
                } else {
                    $out[$path1] = $result;
                }
            }

            return $out;
        } else {
            return $data;
        }
    }

    /**
     * Выполняет запрос методом PUT
     *
     * @param $curlHandle
     * @param Request $request
     * @return Response
     */
    private function executePut($curlHandle, Request $request)
    {
        curl_setopt($curlHandle, CURLOPT_URL, $request->getServiceUrl() . $request->getOperation());

        $requestBody = '';
        $requestLength = 0;

        $requestVars = $request->getParameters();
        if (count($requestVars) > 0) {
            $requestBody = $this->buildPostBody($requestVars);
            $requestLength = strlen($requestBody);
        }

        $fh = fopen('php://memory', 'rw');
        fwrite($fh, $requestBody);
        rewind($fh);

        curl_setopt($curlHandle, CURLOPT_INFILE, $fh);
        curl_setopt($curlHandle, CURLOPT_INFILESIZE, $requestLength);
        curl_setopt($curlHandle, CURLOPT_PUT, true);

        $response = $this->doExecute($curlHandle, $request);

        fclose($fh);

        return $response;
    }

    /**
     * Возвращает POST запрос в виде строки.
     *
     * @param array $parameters
     * @return string
     * @throws \Exception
     */
    private function buildPostBody(array $parameters)
    {
        return http_build_query($parameters, '', '&');
    }

    /**
     * Выполняет запрос методом DELETE.
     *
     * @param $curlHandle
     * @param Request $request
     * @return Response
     */
    private function executeDelete($curlHandle, Request $request)
    {
        curl_setopt($curlHandle, CURLOPT_URL, $request->getServiceUrl() . $request->getOperation());
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, 'DELETE');
        if ($request->getParameters()) {
            curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $this->buildPostBody($request->getParameters()));
        }

        return $this->doExecute($curlHandle, $request);
    }

    /**
     * Возвращает информацию по последнему запросу.
     *
     * @return array
     */
    public function getLastRequestInfo()
    {
        return $this->requestInfo;
    }

}