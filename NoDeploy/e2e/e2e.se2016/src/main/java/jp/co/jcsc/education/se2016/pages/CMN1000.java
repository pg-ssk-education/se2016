package jp.co.jcsc.education.se2016.pages;

import org.openqa.selenium.By;
import org.openqa.selenium.NoSuchElementException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;

public class CMN1000 {

	public static final String TITLE = "ログイン:社内事務効率化ツール";
	public static final String URL = Settings.getString("APP.URL");

	public static final String MESSAGE_FAIL_LOGIN = "ログインできません。ユーザＩＤ、パスワードを確認してください。";

	protected WebDriver driver = null;

	@FindBy(id = "txtLoginId")
	protected WebElement loginId = null;

	@FindBy(id = "txtPassword")
	protected WebElement password = null;

	public CMN1000(WebDriver driver) {
		this.driver = driver;
	}

	public String getLoginId() {
		return this.loginId.getText();
	}

	public void setLoginId(String value) {
		this.loginId.clear();
		this.loginId.sendKeys(value);
	}

	public String getPassword() {
		return this.password.getText();
	}

	public void setPassword(String value) {
		this.password.clear();
		this.password.sendKeys(value);
	}

	public void login() {
		this.driver.findElement(By.id("indexForm")).submit();
	}

	public Boolean canLogin() {

		try {
			return this.loginId.isDisplayed() && this.password.isDisplayed();
		}
		catch (NoSuchElementException ex) {
			return false;
		}

	}

}
