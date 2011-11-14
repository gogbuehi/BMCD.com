
import flash.text.Font;
[Embed(source='fonts/Avenir LT Std/AvenirLTStd-Roman.otf',
    fontName='SiteFont',
    mimeType='application/x-font', 
    advancedAntiAliasing='true')]
private var siteFont:Class;

[Embed(source='fonts/Avenir LT Std/AvenirLTStd-Heavy.otf',
    fontName='SiteFont',
    fontWeight='bold', 
    mimeType='application/x-font', 
    advancedAntiAliasing='true')]
private var siteFontBold:Class;

[Embed(source='fonts/Avenir LT Std/AvenirLTStd-HeavyOblique.otf',
    fontName='SiteFont',
    fontWeight='bold', 
    fontStyle='italic',
    mimeType='application/x-font', 
    advancedAntiAliasing='true')]
private var siteFontBoldItalic:Class;

[Embed(source='fonts/Avenir LT Std/AvenirLTStd-Oblique.otf',
    fontName='SiteFont',
    fontStyle='italic', 
    mimeType='application/x-font', 
    advancedAntiAliasing='true')]
private var siteFontItalic:Class;

[Embed(source='fonts/Avenir LT Std/AvenirLTStd-Black.otf',
    fontName='SiteFontExtra',
    fontWeight='bold', 
    mimeType='application/x-font', 
    advancedAntiAliasing='true')]
private var siteFontExtraBold:Class;

[Embed(source='fonts/Avenir LT Std/AvenirLTStd-BlackOblique.otf',
    fontName='SiteFontExtra',
    fontWeight='bold', 
    fontStyle='italic', 
    mimeType='application/x-font', 
    advancedAntiAliasing='true')]
private var siteFontExtraBoldItalic:Class;

[Embed(source='fonts/Avenir LT Std/AvenirLTStd-Medium.otf',
    fontName='SiteFontSemi',
    mimeType='application/x-font', 
    advancedAntiAliasing='true')]
private var siteFontSemiBold:Class;

[Embed(source='fonts/Avenir LT Std/AvenirLTStd-MediumOblique.otf',
    fontName='SiteFontSemi', 
    fontStyle='italic', 
    mimeType='application/x-font', 
    advancedAntiAliasing='true')]
private var siteFontSemiBoldItalic:Class;
private function registerEmbeds():void{
	Font.registerFont(siteFont);
	Font.registerFont(siteFontBold);
	Font.registerFont(siteFontBoldItalic);
	Font.registerFont(siteFontItalic);
	Font.registerFont(siteFontExtraBold);
	Font.registerFont(siteFontExtraBoldItalic);
	Font.registerFont(siteFontSemiBold);
	Font.registerFont(siteFontSemiBoldItalic);
}