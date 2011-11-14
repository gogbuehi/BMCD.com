package com.hphant.modsite.system
{
	public class URIParse extends Object
	{
		private var _section:String;
		private var _page:String;
		private var _floor:String;
		private var _room:String;
		private var _selection:String;
		public function URIParse(section:String,page:String,floor:String,room:String,selection:String)
		{
			super();
		}
		public function get section():String{return this._section;}
		public function get page():String{return this._page;}
		public function get floor():String{return this._floor;}
		public function get room():String{return this._room;}
		public function get selection():String{return this._selection;}
		
	}
}