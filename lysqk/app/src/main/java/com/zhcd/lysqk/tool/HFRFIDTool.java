package com.zhcd.lysqk.tool;


import android.content.Context;
import android.media.AudioManager;
import android.media.SoundPool;

import com.pda.hf.HFReader;
import com.zhcd.lysqk.R;

import java.util.HashMap;
import java.util.Map;

public class HFRFIDTool {

    private static HFReader hfReader = null;
    public static SoundPool sp;
    public static Map<Integer, Integer> suondMap;

    /**
     * 十六进制UID转为 十进制
     */
    public static String changeToDecimal(String hexString) {
        try {
            //十六进制每两位 倒叙拼接 ，然后转为十进制
            if (hexString.length() < 10) {
                for (int i = 0; i <= 10 - hexString.length(); i++) {
                    hexString = "0" + hexString;
                }
            }
            if (hexString.length() % 2 == 0) {
                String regex = "(.{2})";
                hexString = hexString.replaceAll(regex, "$1 ");
                String[] strings = hexString.split(" ");
                StringBuilder builder = new StringBuilder();
                for (int i = strings.length - 1; i > -1; i--) {
                    builder.append(strings[i]);
                }
                return Long.parseLong(builder.toString(), 16) + "";
            }
        } catch (NumberFormatException e) {
            return "";
        }
        return "";
    }


    public static HFReader getHfReader() {
        if (hfReader == null) {
            hfReader = new HFReader(14, 115200, HFReader.POWER_PSAM);
        }
        return hfReader;
    }

    //
    public static void initSoundPool(Context context) {
        sp = new SoundPool(1, AudioManager.STREAM_MUSIC, 1);
        suondMap = new HashMap<Integer, Integer>();
        suondMap.put(1, sp.load(context, R.raw.msg, 1));
    }

    public static int playAudio(Context context) {
        if (context != null && sp != null && suondMap != null) {
            try {
                AudioManager am = (AudioManager) context.getSystemService(context.AUDIO_SERVICE);
                float audioMaxVolume = am.getStreamMaxVolume(AudioManager.STREAM_MUSIC);
                float audioCurrentVolume = am.getStreamVolume(AudioManager.STREAM_MUSIC);
                float volumnRatio = audioCurrentVolume / audioMaxVolume;
                return sp.play(suondMap.get(1), //
                        audioCurrentVolume, //
                        audioCurrentVolume, //
                        1,
                        0,
                        1);//
            } catch (Exception e) {
                return 0;
            }
        }
        return 0;
    }
}
