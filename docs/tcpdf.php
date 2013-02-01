How to use tcpdf with yii-shop for generation of Invoices and Delivery Slips:

Note that, by default, invoices are generated in .html format. These can
be printed and _may_ look good already. Only use the pdf feature if you
need it.

1.) Install tcpdf:

extract the tcpdf package somewhere in your webroot, in this example
i will use the /var/www/tcpdf/ folder.

2.) Set  'useTcPdf' => true in the application configuration like this:


	'modules' => array(
		'shop' => array(
			'debug' => true,
			'useTcPdf' => true,
			[...]
			),



If your tcpdf installation path varies, you can set the import Path:

	'modules' => array(
		'shop' => array(
			'useTcPdf' => true,
			'tcPdfPath' => 'my.tcpdf.installation.dir.in.yii.path.notation',


3.) Done. Generating a invoice or delivery slip now should render a .pdf file

