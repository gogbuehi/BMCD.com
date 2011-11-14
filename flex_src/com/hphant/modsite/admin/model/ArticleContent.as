package com.hphant.modsite.admin.model
{
	public class ArticleContent extends ModuleContent
	{
		public function ArticleContent()
		{
			super();
		}
		
		public override function get image():XML{
			return null;
		}
		public override function get video():XML{
			return null;
		}
		protected var _title:XML = new XML('<h1 class="Title" />');
		public override function get title():XML{
			return _title;
		}
		protected var _body:XML = new XML('<p calss="Body" />');
		public override function get body():XML{
			return _body;
		}
		public override function get hasImage():Boolean{
			return false;
		}
		public override function get hasVideo():Boolean{
			return false;
		}
		public override function get hasBody():Boolean{
			return true;
		}
		public override function get hasTitle():Boolean{
			return true;
		}
		public override function get imageType():String{
			return ContentTypes.NONE;
		}
		public override function get videoType():String{
			return ContentTypes.NONE;
		}
	}
}