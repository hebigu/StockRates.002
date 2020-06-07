#!/usr/bin/perl

# Start Config

$access_log = "/var/log/httpd/access_log";
$error_log = "/var/log/httpd/error_log";
$default_log = "error"; # access or error
$default_lines = "15";

# End Config

# Print the top of the page
print <<"EOF";
Content-type: text/html

<HTML>
<HEAD>
<TITLE>Viewing $in{'log'} log</TITLE>
</HEAD>
<BODY>
<H1>Log viewing options</H1>
<FORM method="get">
<TABLE>
<TR><TH>Log Type:</TH><TD>Error<INPUT type="radio" value="error" name="log">
&nbsp;&nbsp;Access<INPUT type="radio" value="access" name="log"></TD></TR>
<TR><TH>Lines to show:</TH><TD><INPUT type="text" size="5" name="lines" value="$default_lines"></TD></TR>
<TR><TH>&nbsp</TH><TD><INPUT type="submit" value="Show Log"></TD></TR>
</TABLE>
</FORM>
EOF

# Get values from the query string (not many so we'll not use post)
foreach $pair (split(/&/, $ENV{'QUERY_STRING'})){
$pair =~ tr/+/ /;
($name, $value) = split(/=/, $pair);
$name =~ s/%(..)/pack("C", hex($1))/eg;
$value =~ s/%(..)/pack("C", hex($1))/eg;
$in{$name} = $value;
}
# If specific options were not given then use the defaults
if(!$in{'log'} && ($in{'log'} ne "access" || $in{log} ne "error")){$in{'log'} = $default_log}
if(!$in{'lines'}){$in{'lines'} = $default_lines}
&showlog;

print "</BODY></HTML>";

sub showlog{
print "<H1>Viewing $in{'log'} log</H1><TABLE border=1 width=90%>";
if($in{'log'} eq "access"){
open(LOG, "$access_log");
@line = <LOG>;
close(LOG);
$num = @line;
for($done=0;$done<$in{'lines'};$done++){
$num--;
($start, $request, $response, $ref, $other, $browser, $end) = split (/\"/, $line[$num]);
($browser, $end) = split (/ \(/, $browser);
($client, $other) = split (/\s/, $line[$num]);
($start, $end) = split (/\- /, $line[$num]);
($user, $bad) = split (/ \-/, $end);
($start, $end) = split (/\[/, $line[$num]);
($time, $line[$num]) = split (/\]/, $end);
if($response =~ /^ 200/){$resp = "OK!"}
if($response =~ /^ 500/){$resp = "Server error"}
if($response =~ /^ 404/){$resp = "Page not found"}
if($response =~ /^ 403/){$resp = "Authorisation required"}
if($response =~ /^ 401/){$resp = "Forbidden"}
if($response =~ /^ 400/){$resp = "Bad request"}
if($tm ne $time){print "<TR><TD colspan=4><HR></TD></TR>"}
print "<TR><TD width=35%><B>At:</B> $time<BR><B>User:</B> $client $user<BR><B>Browser:</B> $browser</TD>";
print "<TD width=65%><B>From page:</B> $ref<BR><B>Request:</B> $request<BR><B>Response:</B> $resp ($response)</TD></TR>";
$tm=$time;
}
}
elsif($in{'log'} eq "error"){
open(LOG, "$error_log");
@line = <LOG>;
close(LOG);
$num = @line;
for($done=0;$done<$in{'lines'};$done++){
$num--;
if($line[$num] =~ /^\[.*:..:.*\]/){
$line[$num] =~ tr/\[/ /;
($time, $typ, $cli, $info) = split (/\]/, $line[$num]);
}
else{$info=$line[$num]}
if($line[$num] =~ /\(2\)/){
$cli = "";
$info=$cli;
}
if($tm ne $time){print "<TR><TD colspan=4><HR></TD></TR>"}
print "<TR><TD width=100>$time</TD><TD>$typ</TD><TD width=50>$cli</TD><TD>$info</TD></TR>";
$tm=$time;
}
}
print "</TABLE>";
}

exit;
