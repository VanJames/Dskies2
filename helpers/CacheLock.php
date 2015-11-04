<?php
namespace app\helpers\CacheLock;
/**
 * User: fanxu(746439274@qq.com)
 */
class  CacheLock
{
    //�ļ������·��
    private $path = null;
    //�ļ����
    private $fp = null;
    //������,����Խ������ԽС
    private $hashNum = 10000;
    //cache key
    private $name;
    //�Ƿ����eaccelerator��־
    private  $eAccelerator = false;

    /**
     * ���캯��
     * �������Ĵ��·������cache key�����ƣ��������Խ��в���
     * @param string $path ���Ĵ��Ŀ¼����"/"��β
     * @param string $name cache key
     */
    public function __construct($name,$path='/tmp')
    {
        //�ж��Ƿ����eAccelerator,����������eAccelerator֮����Խ����ڴ������Ч��
        $this->eAccelerator = function_exists("eaccelerator_lock");
        if(!$this->eAccelerator)
        {
            $this->path = $path.($this->_mycrc32($name) % $this->hashNum).'.txt';
        }
        $this->name = $name;
    }

    /**
     * @param $name
     * @param $dir
     * @return CacheLock
     */
    public static function getInstance($name,$dir='/tmp'){
        return new self($name,$dir);
    }

    /**
     * crc32
     * crc32��װ
     * @param int $string
     * @return int
     */
    private function _mycrc32($string)
    {
        $crc = abs (crc32($string));
        if ($crc & 0x80000000) {
            $crc ^= 0xffffffff;
            $crc += 1;
        }
        return $crc;
    }
    /**
     * ����
     * Enter description here ...
     */
    public function lock()
    {
        //����޷�����ea�ڴ����������ļ���
        if(!$this->eAccelerator)
        {
            //����Ŀ¼Ȩ�޿�д
            $this->fp = fopen($this->path, 'w+');
            if($this->fp === false)
            {
                return false;
            }
            return flock($this->fp, LOCK_EX);
        }else{
            return eaccelerator_lock($this->name);
        }
    }

    /**
     * ����
     * Enter description here ...
     */
    public function unlock()
    {
        if(!$this->eAccelerator)
        {
            if($this->fp !== false)
            {
                flock($this->fp, LOCK_UN);
                clearstatcache();
            }
            //���йر�
            fclose($this->fp);
        }else{
            return eaccelerator_unlock($this->name);
        }
    }
}