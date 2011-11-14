
import flash.text.Font;
[Embed(source='fonts/AmericanaStd/AmericanaStd.otf',
    fontName='SiteFont',
    mimeType='application/x-font', 
    advancedAntiAliasing='true')]
private var siteFont:Class;

[Embed(source='fonts/AmericanaStd/AmericanaStd-Bold.otf',
    fontName='SiteFont',
    fontWeight='bold', 
    mimeType='application/x-font', 
    advancedAntiAliasing='true')]
private var siteFontBold:Class;

[Embed(source='fonts/AmericanaStd/AmericanaStd-Italic.otf',
    fontName='SiteFont',
    fontStyle='italic', 
    mimeType='application/x-font', 
    advancedAntiAliasing='true')]
private var siteFontItalic:Class;

[Embed(source='fonts/AmericanaStd/AmericanaStd-ExtraBold.otf',
    fontName='SiteFontExtra',
    fontWeight='bold', 
    mimeType='application/x-font', 
    advancedAntiAliasing='true')]
private var siteFontExtraBold:Class;
private function registerEmbeds():void{
	Font.registerFont(siteFont);
	Font.registerFont(siteFontBold);
	Font.registerFont(siteFontItalic);
	Font.registerFont(siteFontExtraBold);
}