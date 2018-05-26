package com.zhcd.lysqk.tool;


import android.content.Context;
import android.media.AudioManager;
import android.media.SoundPool;

import com.pda.hf.HFReader;
import com.zhcd.lysqk.R;

public class HFRFIDTool {

    private static HFReader hfReader = null;
    public static SoundPool sp;

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


    public static HFReader getHfReader() {
        if (hfReader == null) {
            hfReader = new HFReader(14, 115200, HFReader.POWER_PSAM);
        }
        return hfReader;
    }

    public static void playAudio(Context context) {
        if (context != null) {
            try {
                sp = new SoundPool(1, AudioManager.STREAM_MUSIC, 1);
                AudioManager am = (AudioManager) context.getSystemService(context.AUDIO_SERVICE);
                float audioMaxVolume = am.getStreamMaxVolume(AudioManager.STREAM_MUSIC);
                float audioCurrentVolume = am.getStreamVolume(AudioManager.STREAM_MUSIC);
                float volumnRatio = audioCurrentVolume / audioMaxVolume;
                sp.play(R.raw.msg, audioCurrentVolume, audioCurrentVolume, 1, 0, 1);
            } catch (Exception e) {
            }
        }
    }
}
