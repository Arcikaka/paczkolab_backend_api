<img alt="Logo" src="http://coderslab.pl/svg/logo-coderslab.svg" width="400">

# PHP Paczkolab 4




# Tests #

Tests that I make to check if my code works well with database are very simple and can be
converted to another code very easy.

In this tests very important is to use another database (for example databse_test) with following entries:

In Size:

	<table_data name="Size">
	<row>
		<field name="id">1</field>
		<field name="size">S</field>
		<field name="price">8.00</field>
	</row>
	<row>
		<field name="id">2</field>
		<field name="size">M</field>
		<field name="price">12.00</field>
	</row>
	</table_data>

In User:

	<table_data name="User">
	<row>
		<field name="id">1</field>
		<field name="name">John</field>
		<field name="surname">Marston</field>
		<field name="credits">15.00</field>
		<field name="addressId">2</field>
	</row>
	</table_data>


And in Parcel:

	<table_data name="Parcel">
	<row>
		<field name="id">1</field>
		<field name="userId">1</field>
		<field name="sizeId">2</field>
		<field name="addressId">2</field>
	</row>
	</table_data>

Address:

	<table_data name="Address">
		<row>
			<field name="id">2</field>
			<field name="city">Poznan</field>
			<field name="code">62-100</field>
			<field name="street">Doznan</field>
			<field name="flat">201</field>
		</row>
	</table_data>


Sequence of the test is very important!!