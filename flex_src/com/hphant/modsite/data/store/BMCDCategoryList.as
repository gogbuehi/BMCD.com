package com.hphant.modsite.data.store
{
	public class BMCDCategoryList
	{
		public function BMCDCategoryList()
		{
			if(BMCDCategoryList._instance){
				throw new Error("Only one instance of this class may exist. Use BMCDCategoryList.getInstance()");
			}
		}
		private static var _instance:BMCDCategoryList;
		public static function getInstance():BMCDCategoryList{
			if(!_instance){
				_instance = new BMCDCategoryList();
			}
			return _instance;
		}
		
		private var _xml:XMLList;
		public function set xml(value:XMLList):void{
			if(this._xml != value){
				this._xml = value;
				this.createList();
			}
		}
		public function get xml():XMLList{return this._xml;}
		private var _list:XMLList = new XMLList("");
		public function get list():XMLList{
			return this._list;
		}
		private function createList():void{
			var cats:Array = new Array();
			for each (var td:XML in this._xml){
				cats = cats.concat(this.tdToArray(td));
			}
			cats.sort();
			this._list = sumCategories(cats,this._xml.length());
		}
		private function sumCategories(array:Array,itemcount:int):XMLList{
			var cnt:int = 1;
			var lis:String = "";
			var temp:String = array.pop();
			var cname:String = "";
			while (array.length>0){
				cname = array.pop();
					if(cname==temp){
						cnt++;
					} else {
						lis+="<li class='subsection' id='"+temp+"'><a href='"+temp+"'>"+temp+" ("+cnt+")</a></li>";
						temp = cname;
						cnt = 1;
					}
				
			}
			lis = "<li class='subsection' id='all'><a href='all'>all ("+itemcount+")</a></li>"+
				   lis+"<li class='subsection' id='"+temp+"'><a href='"+temp+"'>"+temp+" ("+cnt+")</a></li>";
			return XMLList("<ul>"+lis+"</ul>");
		}
		private function tdToArray(td:XML):Array{
			return td.toString().split(",");
		}
		private function arrayToXMLList(array:Array):XMLList{
			var lis:String = "";
			for each(var cat:String in array){
				lis+="<li>"+cat+"</li>";
			}
			return XMLList(lis);
		}
	}
}