package com.hphant.modsite.data.calendar
{
	import com.hphant.utils.IGroupFilter;
	
	import flash.utils.Dictionary;
	
	import mx.collections.ArrayCollection;
	import mx.collections.ListCollectionView;
	import mx.collections.Sort;
	import mx.collections.SortField;

	public class BMCDEventGroupFilter implements IGroupFilter
	{
		public function BMCDEventGroupFilter()
		{
		}
		private var di:BMCDEventItemData =  new BMCDEventItemData();
		public function getGroupValue(item:Object):Object
		{
			di.row = XML(item);
			var date:Array = String(di.date.data).split("/");
			var groupid:String = date[2]+"_"+BMCDEventGroupFilter.months[Number(date[0])-1];
			return groupid;
		}
		public function sortGroups(groups:Array):void{
			BMCDEventGroupFilter.sort.compareFunction = BMCDEventGroupFilter.compare;
			BMCDEventGroupFilter.sort.sort(groups);
			insertEmptyGroups(groups);
		}
		public static var startYear:Number;
		public static var startMonth:Number;
		public static var minGroups:Number = 0;
		private function insertEmptyGroups(groups:Array):void{
			var startDate:Date = new Date();
			var gac:ArrayCollection = new ArrayCollection(groups);
			var group1:ArrayCollection = (groups && groups.length>0) ? groups[0] : null;
			var sg:ArrayCollection = group1;
			if(!startYear){
				startDate.fullYear = (group1) ? getGroupDate(group1).y : startDate.fullYear;
			} else {
				startDate.fullYear = startYear;
			}
			if(!startMonth){
				startDate.month = (group1) ? getGroupDate(group1).m-1 : startDate.month;
				startDate.month--;
				startMonth = startDate.month+1;
			} else {
				startDate.month = startMonth-1;
			}
			startYear = startDate.fullYear;
			var endDate:Date = new Date(startYear,startMonth);
			endDate.month = endDate.month+((minGroups) ? minGroups : 0);
			var d1:Object = (group1) ? getGroupDate(group1) : {m:endDate.month,y:endDate.fullYear,d:1};
			var sd:Object = d1;
			var nac:ArrayCollection;
			var yo:Number = 0;
			var mo:Number = 0;
			var cm:Number = startMonth;
			for each(var group2:ArrayCollection in groups.concat([])){
					d1 = getGroupDate(group1);
					var d2:Object = getGroupDate(group2);
					BMCDEventGroupFilter.groupLabels[group2] = d2.y+" "+BMCDEventGroupFilter.months[Number(d2.m)-1];
					yo = 0;
					mo = 0;
				if(group1.length>0 && group2.length>0){
					if(Number(d1.y)==Number(d2.y)){
						
						while(Number(d1.m)+mo+1<Number(d2.m)){
							mo++;
							nac = new ArrayCollection();
							BMCDEventGroupFilter.groupLabels[nac] = Number(d1.y+yo)+" "+BMCDEventGroupFilter.months[Number(d1.m+mo)-1];
							gac.addItemAt(nac,gac.getItemIndex(group1)+mo);
						}
					} else if(Number(d1.y)<Number(d2.y)){
						cm = d1.m;
						while(Number(d1.y)+yo<=Number(d2.y)){
							mo++;
							if(cm+1==13){
								yo++;
								cm = 1;
							} else {
								cm++;
							}
							
							nac = new ArrayCollection();
							BMCDEventGroupFilter.groupLabels[nac] = Number(d1.y+yo)+" "+BMCDEventGroupFilter.months[Number(cm)-1];
							gac.addItemAt(nac,gac.getItemIndex(group1)+mo);
							if((Number(d1.y)+yo==Number(d2.y))&&(cm+1==Number(d2.m))){
								break;
							}
						}
					}
				}
				group1 = group2;
			}
			
			yo = 0;
			mo = 0;
			cm = startMonth;
			 while(gac.length<minGroups){
				if((startYear+yo==Number(sd.y))&&(cm==Number(sd.m))){
					var lid:Array = String(BMCDEventGroupFilter.groupLabels[gac.getItemAt(gac.length-1)]).split(" ");
					startYear = Number(lid[0]);
					yo = 0;
					var nameCollection:ArrayCollection = new ArrayCollection(BMCDEventGroupFilter.months);
					cm = nameCollection.getItemIndex(lid[1])+1;
					mo = gac.length;
				} else {
					nac = new ArrayCollection();
					BMCDEventGroupFilter.groupLabels[nac] = Number(startYear+yo)+" "+BMCDEventGroupFilter.months[Number(cm)-1];
					trace("Need to add empty group "+BMCDEventGroupFilter.groupLabels[nac]+" at "+(mo));
					gac.addItemAt(nac,mo);
					mo++;
				}
				if(cm+1==13){
					yo++;
					cm = 1;
				} else {
					cm++;
				}
			 }
		}
		public function sortAll(data:ListCollectionView):void{
			data.sort = new Sort();
			data.sort.compareFunction = BMCDEventGroupFilter.compareAllItems;
			data.refresh();
		}
		private static var sortFields:Array = [new SortField("date",false,true)];
		private static var sort:Sort = new Sort();
		public static const months:Array = ["January","February","March","April","May","June","July","August","September","October","November","December"];
		public static var groupLabels:Dictionary = new Dictionary(true);
		private function getGroupDate(group:ArrayCollection):Object{
			var tdIndex:int = BMCDEventItemData.getHeaderIndex(BMCDEventItemData.names['date']);
			var a:Array = (group) ? String(XML(XML(group.getItemAt(0)).td[tdIndex]).children()).split("/") : ["0","0","0"];
			return {m:Number(a[0]),d:Number(a[1]),y:Number(a[2])};
		}
		private static function compare(a:ArrayCollection,b:ArrayCollection,fields:Array=null):int{
			log("compare() --------------------------------------------------------");
			var result:int = 0;
            var i:int = 0;
            var d:Object;
            var e:Object;
            var len:int = sortFields.length;
            var propName:String;
            var tdIndex:int;
            while (result == 0 && (i < len))
            {
                propName = SortField(sortFields[i]).name;
                log("Compare on "+propName);
                tdIndex = BMCDEventItemData.getHeaderIndex(BMCDEventItemData.names[propName]);
                try{
                	e = rearangeDate((SortField(sortFields[i]).descending) ? (!b) ? b : XML(XML(b.getItemAt(0)).td[tdIndex]).children() : (!a) ? a : XML(XML(a.getItemAt(0)).td[tdIndex]).children());
               		log("\tb="+e);
               	}catch(er:Error){
               		e = null;
               	}
                 try{
                	d = rearangeDate((SortField(sortFields[i]).descending) ? (!a) ? a : XML(XML(a.getItemAt(0)).td[tdIndex]).children() : (!b) ? b : XML(XML(b.getItemAt(0)).td[tdIndex]).children());
          			log("\ta="+d);
          		}catch(er:Error){
               		d = null;
               	}
          		switch(propName){
          			
          			default:
          				result = compareValues(d, e);
          				log("\tresult="+result);
          			break;
          		}
                i++;
            }
            return result;
		}
		private static function rearangeDate(mmddyyyy:Object):String{
			var yyyymmdd:String = "";
			var dArray:Array = String(mmddyyyy).split("/");
			yyyymmdd = String(dArray[2]+""+dArray[0]+""+dArray[1]);
			return yyyymmdd;
		}
		private static function compareAllItems(a:XML,b:XML,fields:Array=null):int{
			log("compareAllItems() --------------------------------------------------------");
			var result:int = 0;
            var i:int = 0;
            var d:Object;
            var e:Object;
            var len:int = sortFields.length;
            var propName:String;
            var tdIndex:int;
            while (result == 0 && (i < len))
            {
                propName = SortField(sortFields[i]).name;
                log("Compare on "+propName);
                tdIndex = BMCDEventItemData.getHeaderIndex(BMCDEventItemData.names[propName]);
                try{
                	e = rearangeDate((SortField(sortFields[i]).descending) ? (!b) ? b : b.td[tdIndex].children() : (!a) ? a : a.td[tdIndex].children());
               		log("\tb="+e);
               	}catch(er:Error){
               		e = null;
               	}
                 try{
                	d = rearangeDate((SortField(sortFields[i]).descending) ? (!a) ? a : a.td[tdIndex].children() : (!b) ? b : b.td[tdIndex].children());
          			log("\ta="+d);
          		}catch(er:Error){
               		d = null;
               	}
          		switch(propName){
          			
          			default:
          				result = compareValues(d, e);
          				log("\tresult="+result);
          			break;
          		}
                i++;
            }
            return result;
		}
		private static function compareValues(a:Object, b:Object):int{
            return (a == null && b == null) ? 0 : (a == null) ? 1 : (b == null || a < b) ? -1 : (a > b) ? 1 : 0;
        }
        private static function log(message:Object,level:int=0):void{
        	//Logger.log("[BMCDEventGroupFilter Class] "+message,level);
        }
	}
}