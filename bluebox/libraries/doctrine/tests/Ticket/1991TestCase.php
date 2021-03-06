<?php
/*
 *  $Id$
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.phpdoctrine.org>.
 */

/**
 * Doctrine_Ticket_1015_TestCase
 *
 * @package     Doctrine
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @category    Object Relational Mapping
 * @link        www.phpdoctrine.org
 * @since       1.0
 * @version     $Revision$
 */
class Doctrine_Ticket_1991_TestCase extends Doctrine_UnitTestCase {

    public function prepareTables() {
        $this->tables = array();
        $this->tables[] = 'NewTag';

        parent::prepareTables();
    }

    public function prepareData()
    {
        $tag = new NewTag();
        $tag->name = 'name';
        $tag->save();
        
        $tag = new NewTag();
        $tag->name = 'foobar';
        $tag->save();        
    }


    public function testHydratation()
    {
        $q = new Doctrine_Query();
        $q->select('t.name')->from('NewTag t INDEXBY t.name');        
        try {
            $results = $q->execute(array(), Doctrine::HYDRATE_ARRAY);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

}

class NewTag extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('tag');
        $this->hasColumn('name', 'string', 100, array('type' => 'string', 'length' => '100'));
    }
}
