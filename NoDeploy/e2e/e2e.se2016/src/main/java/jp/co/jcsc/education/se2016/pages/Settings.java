package jp.co.jcsc.education.se2016.pages;

import java.util.MissingResourceException;
import java.util.ResourceBundle;

public class Settings {
	private static final String BUNDLE_NAME = "jp.co.jcsc.education.se2016.pages.settings";

	private static final ResourceBundle RESOURCE_BUNDLE = ResourceBundle.getBundle(BUNDLE_NAME);

	private Settings() {
	}

	public static String getString(String key) {
		try {
			return RESOURCE_BUNDLE.getString(key);
		} catch (MissingResourceException e) {
			return '!' + key + '!';
		}
	}
}
