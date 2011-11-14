package com.hphant.modsite.site.forms
{
	public class EmailFriendFormDataMap extends EmailFormDataMap
	{
		public function EmailFriendFormDataMap()
		{
		}
		public override function get data1():String{return "fromFirstName";}
		public override function get data2():String{return "fromEmail";}
		public override function get data3():String{return "toFirstName";}
		public override function get data4():String{return "toEmail";}
		public override function get message():String{return "message";}

	}
}