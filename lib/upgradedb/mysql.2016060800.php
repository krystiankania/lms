<?php

/*
 * LMS version 1.11-git
 *
 *  (C) Copyright 2001-2016 LMS Developers
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 *
 */

$this->BeginTrans();

$this->Execute("ALTER TABLE voip_cdr CHANGE status status smallint NOT NULL");

$this->Execute("ALTER TABLE voip_cdr CHANGE type type smallint NOT NULL");

$this->Execute("ALTER TABLE voip_cdr ADD COLUMN calleevoipaccountid int(11) NULL, ADD CONSTRAINT FOREIGN KEY(calleevoipaccountid) REFERENCES voipaccounts(id)");

$this->Execute("ALTER TABLE voip_cdr ADD COLUMN caller_flags smallint NOT NULL DEFAULT 0");

$this->Execute("ALTER TABLE voip_cdr ADD COLUMN callee_flags smallint NOT NULL DEFAULT 0");

$this->Execute("ALTER TABLE voip_cdr ADD COLUMN caller_prefix_group varchar(30) NULL");

$this->Execute("ALTER TABLE voip_cdr ADD COLUMN callee_prefix_group varchar(30) NULL");

$this->Execute("ALTER TABLE voip_cdr ADD COLUMN uniqueid varchar(20) NOT NULL");

$this->Execute("ALTER TABLE voip_cdr CHANGE voipaccountid callervoipaccountid INT(11) NULL, ADD CONSTRAINT FOREIGN KEY(callervoipaccountid) REFERENCES voipaccounts(id)");

$this->Execute("ALTER TABLE voipaccounts ADD COLUMN flags smallint NOT NULL DEFAULT 0");

$this->Execute("ALTER TABLE voip_prefixes ADD groupid int(11) NOT NULL, ADD CONSTRAINT FOREIGN KEY(groupid) REFERENCES voip_prefix_groups(id)");

$this->Execute("DROP TABLE voip_prefix_group_assignments");

$this->Execute("ALTER TABLE voip_prefixes DROP COLUMN name");

$this->Execute("ALTER TABLE voip_prefixes DROP COLUMN description");

$this->Execute("ALTER TABLE voip_tariffs DROP FOREIGN KEY voip_tariffs_ibfk_1");

$this->Execute("ALTER TABLE voip_tariffs DROP COLUMN prefixid");

$this->Execute("ALTER TABLE voip_tariff_rules DROP FOREIGN KEY voip_tariff_rules_ibfk_1");

$this->Execute("ALTER TABLE voip_tariff_rules DROP COLUMN prefixid");

$this->Execute("ALTER TABLE voip_tariffs CHANGE groupid groupid int(11) NOT NULL");

$this->Execute("ALTER TABLE voip_tariff_rules CHANGE groupid groupid int(11) NOT NULL");

$this->Execute("ALTER TABLE voip_tariff_rules ADD COLUMN rule_settings text NULL");

$this->Execute("ALTER TABLE voip_tariffs CHANGE price price decimal(12,5) NOT NULL");

$this->Execute("ALTER TABLE voip_tariff_rules DROP COLUMN unitsize");

$this->Execute("ALTER TABLE voip_tariff_rules DROP COLUMN price");

$this->Execute("ALTER TABLE voip_prefix_groups ENGINE = InnoDB;");

$this->Execute("ALTER TABLE voip_prefixes ENGINE = InnoDB;");

$this->Execute("ALTER TABLE voip_tariffs ENGINE = InnoDB;");

$this->Execute("ALTER TABLE voip_tariff_rules ENGINE = InnoDB;");

$this->Execute("ALTER TABLE voip_cdr ENGINE = InnoDB;");

define('CONFIG_TYPE_POSITIVE_INTEGER', 2);
$this->Execute("INSERT INTO uiconfig (section, var, value, type) VALUES('phpui', 'billinglist_pagelimit', '100', ?)", array(CONFIG_TYPE_POSITIVE_INTEGER));

$this->Execute("UPDATE dbinfo SET keyvalue = ? WHERE keytype = ?", array('2016060800', 'dbversion'));

$this->CommitTrans();

?>