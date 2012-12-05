<?php
namespace xPDO\reflect;

class xPDOReflectionClass extends \ReflectionClass {
    /**
     * @param \ReflectionClass|\ReflectionFunctionAbstract $element
     * @param int|null $start
     * @param bool|int|null $end
     */
    public function getSource($element = null, $start = null, $end = false, $includeComment = true) {
        $source = false;
        /* @var \ReflectionClass|\ReflectionFunctionAbstract $element */
        if ($element === null) $element =& $this;
        if ($element instanceof \ReflectionClass || $element instanceof \ReflectionFunctionAbstract) {
            if (is_readable($element->getFileName())) {
                try {
                    $sourceArray = $this->getSourceArray($element, $start, $end);
                    if ($includeComment) {
                        $comment = $element->getDocComment();
                        if (!empty($comment)) {
                            array_unshift($sourceArray, "    {$comment}\n");
                        }
                    }
                    $source = implode('', $sourceArray);
                } catch (\Exception $e) {
                    throw new \xPDO\xPDOException("Error getting source from Reflection element: {$e->getMessage()}");
                }
            }
        }
        return $source;
    }

    /**
     * @param \ReflectionClass|\ReflectionFunctionAbstract $element
     * @param int|null $start
     * @param bool|int|null $end
     * @return array
     */
    public function getSourceArray($element = null, $start = null, $end = false) {
        $sourceArray = false;
        /* @var \ReflectionClass|\ReflectionFunctionAbstract $element */
        if ($element === null) $element =& $this;
        if (($element instanceof \ReflectionClass || $element instanceof \ReflectionFunctionAbstract) && is_readable($element->getFileName())) {
            $startOffset = is_int($start) ? $start : $element->getStartLine() - 1;
            $endOffset = is_int($end) || is_null($end) ? $end : ($element->getEndLine() - $element->getStartLine()) + 1;
            $sourceArray = array_slice(file($element->getFileName()), $startOffset, $endOffset);
        }
        return $sourceArray;
    }
}