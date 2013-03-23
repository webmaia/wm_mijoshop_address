wm_mijoshop_address
===================

update form table with #_mijoshop_address form of seblod


This field updates table # _mijoshop_address. To extend the values to mijoshop must set for each field on which field will retrieve the value:
Company -&gt; company
Address, No -&gt; address_1
District -&gt; address_2
Country -&gt; country_id (INT) to be equal to the corresponding table # _mijoshop_country (select Use dynamic, select single or cascaded with select Options Name = name and Options Value = country_id).
State -&gt; zone_id (INT) to be equal to the corresponding table # _mijoshop_zone (select Use dynamic, select single or cascaded with select Options Name = name and Options Value = zone_id).
Postcode -&gt; postcode (VARCHAR)<br />
City -&gt; city (VARCHAR)
