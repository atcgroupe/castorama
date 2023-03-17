<?php

namespace App\Service\Api;

use App\Entity\AbstractVariableOrderSign;
use App\Entity\Order;
use App\Service\Order\OrderSignHelper;
use Symfony\Component\Serializer\SerializerInterface;
use ZipArchive;

class OrderSignsDataHelper
{
    public function __construct(
        private readonly OrderSignHelper $signHelper,
        private readonly SerializerInterface $serializer,
    ) {
    }

    /**
     * @param Order $order
     *
     * @return string
     */
    public function generateXmlZipFile(Order $order): string
    {
        $signs = $this->signHelper->findAll($order);

        $zip = new ZipArchive();
        $file = tempnam(sys_get_temp_dir(), 'order_xml_zip');
        $zip->open($file, ZipArchive::CREATE);

        foreach ($signs as $sign) {
            if ($sign instanceof AbstractVariableOrderSign) {
                $sign->setData($this->serializer->serialize($sign, 'json', ['groups' => 'api_json_data']));
            }

            $zip->addFromString(
                $sign->getXmlFilename(),
                $this->serializer->serialize(
                    $sign,
                    'xml',
                    [
                        'groups' => 'api_xml_object',
                        'xml_format_output' => true,
                        'xml_encoding' => 'utf-8',
                        'xml_root_node_name' => 'orderSign'
                    ]
                )
            );
        }

        $zip->close();

        return $file;
    }
}
