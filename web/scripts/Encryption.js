var Encryption = {
    //Requires jQuery
    charMap:new Array(),
    alphaMap:new Array(),
    numeralBase:36,
    /**
     * Retrieves the character map to use for Stage 1 encryption
     */
    retrieveCharacterMap:function() {
        this.charMap[1]='t';
        this.charMap[2]='h';
        this.charMap[3]='e';
        this.charMap[4]='q';
        this.charMap[5]='u';
        this.charMap[6]='i';
        this.charMap[7]='c';
        this.charMap[8]='k';
        this.charMap[9]='b';
        this.charMap[10]='r';
        this.charMap[11]='o';
        this.charMap[12]='w';
        this.charMap[13]='n';
        this.charMap[14]='f';
        this.charMap[15]='-';
        this.charMap[16]='x';
        this.charMap[17]='j';
        this.charMap[18]='_';
        this.charMap[19]='m';
        this.charMap[20]='p';
        this.charMap[21]='=';
        this.charMap[22]='d';
        this.charMap[23]='+';
        this.charMap[24]='v';
        this.charMap[25]=';';
        this.charMap[26]=':';
        this.charMap[27]='\'';
        this.charMap[28]='"';
        this.charMap[29]=',';
        this.charMap[30]='l';
        this.charMap[31]='a';
        this.charMap[32]='z';
        this.charMap[33]='y';
        this.charMap[34]='.';
        this.charMap[35]='@';
        this.charMap[36]='g';
        this.charMap[37]='s';

    },
    retrieveAlphaMap:function() {
        this.alphaMap[10]='a';
        this.alphaMap[11]='b';
        this.alphaMap[12]='c';
        this.alphaMap[13]='d';
        this.alphaMap[14]='e';
        this.alphaMap[15]='f';
        this.alphaMap[16]='g';
        this.alphaMap[17]='h';
        this.alphaMap[18]='i';
        this.alphaMap[19]='j';
        this.alphaMap[20]='k';
        this.alphaMap[21]='l';
        this.alphaMap[22]='m';
        this.alphaMap[23]='n';
        this.alphaMap[24]='o';
        this.alphaMap[25]='p';
        this.alphaMap[26]='q';
        this.alphaMap[27]='r';
        this.alphaMap[28]='s';
        this.alphaMap[29]='t';
        this.alphaMap[30]='u';
        this.alphaMap[31]='v';
        this.alphaMap[32]='w';
        this.alphaMap[33]='x';
        this.alphaMap[34]='y';
        this.alphaMap[35]='z';
        this.alphaMap[36]='\'';
        this.alphaMap[37]='"';
        this.alphaMap[38]=',';
        this.alphaMap[39]='@';
        this.alphaMap[40]='-';
        this.alphaMap[41]='_';
        this.alphaMap[42]=';';
        this.alphaMap[43]='+';
        this.alphaMap[44]='=';
        this.alphaMap[45]=':';
    },
    getCharacterValue:function(one_char) {
        if (!isNaN(parseInt(one_char))) {
            return this.getNumericValue(parseInt(one_char));
        }
        var currentChar;
        for(var i = 1; i <= this.charMap.length; i++) {
            currentChar = "" + (this.charMap[i]);
            if (currentChar == one_char) {
                return i;
            }
            if (currentChar.toUpperCase() == one_char) {
                return this.getUpperCaseValue(i);
            }

        }
        return -1;
    },
    getNumericValue:function(value) {
        return ((value*2) + this.charMap.length + 1);
    },
    getUpperCaseValue:function(value) {
        return ((value*2) + this.charMap.length);
    },
    fromValue:function(value) {
        if (value <= this.charMap.length) {
            return this.charMap[value];
        }
        var offsetValue = value - this.charMap.length;
        if (offsetValue % 2 == 1) {
            offsetValue = (offsetValue-1)/2;
            return "" + (offsetValue);
        }
        else {
            offsetValue = offsetValue/2;
            return ("" +(this.charMap[offsetValue])).toUpperCase();
        }
        return null;
    },
    toNumeral:function(value) {
        this.numeralBase = this.alphaMap.length + 10;
        var firstValue = value % this.numeralBase;
        var secondValue = (value-firstValue) / this.numeralBase;
        return (this.numeralDigit(secondValue) + this.numeralDigit(firstValue))
    },
    numeralDigit:function(value) {
        return ((value < 10) ? value + "" : this.alphaMap[value]);
    },
    /**
     * Convert an EncryptNumeral back to a decimal value
     * Note: Only 2-digit values should be provided
     */
    fromNumeral:function(value) {
        var valueString = "" + (value);
        var index,currentChar,sumValue=0;
        for(var i; i < valueString.length; i++) {
            index = valueString.length - (1 + i);
            currentChar = valueString.charAt(index);
            sumValue += this.numeralDigitValue(currentChar) * Math.pow(this.alphaMap.length,index);
        }
        return sumValue;
    },
    numeralDigitValue:function(one_char) {
        var strChar;
        for (var i = 0; i < 10; i++) {
            if (i >= 0 && i < 10) {
                if (one_char === ("" +  i)) {
                    return i;
                }
            }
            else {
                strChar = "" + (one_char);
                if(strChar.toLowerCase() == this.alphaMap[i]) {
                    return i;
                }
            }
        }
        return -1;
    },
    getEncryptedCharacter:function(value) {
        return value;
    },
    encryptCharacter:function(one_char) {
        var charValue = this.getCharacterValue(one_char);
        var numeralString = this.toNumeral(charValue);
        return numeralString;
    },
    caesarCypher:function(one_char) {

    },
    encryptString:function(aString) {
        var cString = "";
        for (var i=0; i<aString.length; i++) {
            cString += this.encryptCharacter(aString.charAt(i));
        }
        return cString;
    }
}