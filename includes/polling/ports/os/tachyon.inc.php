<?php

$wireless_stats = snmpwalk_group($device, 'wirelessPeersTable', 'TACHYON-MIB');

$offset = 1000;

foreach ($wireless_stats as $index => $wireless_entry) {
    $curIfIndex = $offset + $index;

    $port_stats[$curIfIndex]['ifPhysAddress'] = strtolower(str_replace(':', '', $wireless_entry['wirelessPeerMac'] ?? null));
    $port_stats[$curIfIndex]['ifDescr'] = $wireless_entry['wirelessPeerName'] ?? null;
    $port_stats[$curIfIndex]['ifName'] = $wireless_entry['wirelessPeerName'] ?? null;
    $port_stats[$curIfIndex]['ifSpeed'] = ($wireless_entry['wirelessPeerTxRate'] ?? null) * 1000000;
    $port_stats[$curIfIndex]['ifType'] = 'ieee80211';
    $port_stats[$curIfIndex]['ifInOctets'] = $wireless_entry['wirelessPeerRxBytes'] ?? null;
    $port_stats[$curIfIndex]['ifOutOctets'] = $wireless_entry['wirelessPeerTxBytes'] ?? null;
    $port_stats[$curIfIndex]['ifInUcastPkts'] = $wireless_entry['wirelessPeerRxPackets'] ?? null;
    $port_stats[$curIfIndex]['ifOutUcastPkts'] = $wireless_entry['wirelessPeerTxPackets'] ?? null;
    $port_stats[$curIfIndex]['ifOperStatus'] = ($wireless_entry['wirelessPeerLinkUptime'] ?? 0) > 0 ? 'up' : 'down';
    $port_stats[$curIfIndex]['ifAdminStatus'] = ($wireless_entry['wirelessPeerLinkUptime'] ?? 0) > 0 ? 'up' : 'down';
}

unset($wireless_stats);