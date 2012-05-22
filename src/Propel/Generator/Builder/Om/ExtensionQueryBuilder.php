<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Propel\Generator\Builder\Om;

/**
 * Generates the empty PHP5 stub class for object query
 *
 * This class produces the empty stub class that can be customized with application
 * business logic, custom behavior, etc.
 *
 * @author Francois Zaninotto
 */
class ExtensionQueryBuilder extends AbstractOMBuilder
{

    /**
     * Returns the name of the current class being built.
     * @return     string
     */
    public function getUnprefixedClassName()
    {
        return $this->getTable()->getPhpName() . 'Query';
    }

    /**
     * Adds class phpdoc comment and openning of class.
     * @param      string &$script The script will be modified in this method.
     */
    protected function addClassOpen(&$script)
    {
        $table = $this->getTable();
        $tableName = $table->getName();
        $tableDesc = $table->getDescription();
        $baseClassName = $this->getClassNameFromBuilder($this->getQueryBuilder());

        $script .= "

/**
 * Skeleton subclass for performing query and update operations on the '$tableName' table.
 *
 * $tableDesc
 *";
        if ($this->getBuildProperty('addTimeStamp')) {
            $now = strftime('%c');
            $script .= "
 * This class was autogenerated by Propel " . $this->getBuildProperty('version') . " on:
 *
 * $now
 *";
        }
        $script .= "
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class ".$this->getUnqualifiedClassName()." extends $baseClassName {
";
    }

    /**
     * Specifies the methods that are added as part of the stub query class.
     *
     * By default there are no methods for the empty stub classes; override this method
     * if you want to change that behavior.
     *
     * @see QueryBuilder::addClassBody()
     */

    protected function addClassBody(&$script)
    {
    }

    /**
     * Closes class.
     * @param      string &$script The script will be modified in this method.
     */
    protected function addClassClose(&$script)
    {
        $script .= "
} // " . $this->getUnqualifiedClassName() . "
";
        $this->applyBehaviorModifier('extensionQueryFilter', $script, "");
    }

    /**
     * Checks whether any registered behavior on that table has a modifier for a hook
     * @param string $hookName The name of the hook as called from one of this class methods, e.g. "preSave"
     * @return Boolean
     */
    public function hasBehaviorModifier($hookName, $modifier = null)
    {
         return parent::hasBehaviorModifier($hookName, 'QueryBuilderModifier');
    }

    /**
     * Checks whether any registered behavior on that table has a modifier for a hook
     * @param string $hookName The name of the hook as called from one of this class methods, e.g. "preSave"
     * @param string &$script The script will be modified in this method.
     */
    public function applyBehaviorModifier($hookName, &$script, $tab = "        ")
    {
        return $this->applyBehaviorModifierBase($hookName, 'QueryBuilderModifier', $script, $tab);
    }

    /**
     * Checks whether any registered behavior content creator on that table exists a contentName
     * @param string $contentName The name of the content as called from one of this class methods, e.g. "parentClassName"
     */
    public function getBehaviorContent($contentName)
    {
        return $this->getBehaviorContentBase($contentName, 'QueryBuilderModifier');
    }

}
