package com.zhcd.lysqk.tool;


import com.pda.hf.HFReader;

public class HFRFIDTool {
    /**
     * 十六进制UID转为 十进制
     */
    public static int changeToDecimal(String hexString) {
        //十六进制每两位 倒叙拼接 ，然后转为十进制
        if (hexString.length() % 2 == 0) {
            String regex = "(.{2})";
            hexString = hexString.replaceAll(regex, "$1 ");
            String[] strings = hexString.split(" ");
            StringBuilder builder = new StringBuilder();
            for (int i = strings.length - 1; i > -1; i--) {
                builder.append(strings[i]);
            }
            return Integer.valueOf(builder.toString(), 16);
        }
        return 0;
    }
    private static HFReader hfReader = null;

    public static HFReader getHfReader() {
        if (hfReader == null) {
            hfReader = new HFReader(14, 115200, HFReader.POWER_PSAM);
        }
        return hfReader;
    }
}
