package jp.co.jcsc.education.se2016.pages;

import static org.hamcrest.CoreMatchers.*;

import org.junit.After;
import org.junit.Assert;
import org.junit.Before;
import org.junit.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.TimeoutException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedCondition;
import org.openqa.selenium.support.ui.WebDriverWait;

public class CMN1000Test {

	private WebDriver driver= null;

	@Before
	public void setUp() {
		// todo Driverの取り回しを整理する
		this.driver = new ChromeDriver();
	}

	@After
	public void tearDown() {
		this.driver.quit();
		this.driver = null;
	}

	@Test
	public void ログイン画面は未ログインの場合にログイン待機状態となること() {
		// [準備]

		// [実行]
		this.driver.get(CMN1000.URL);
		CMN1000 page = PageFactory.initElements(this.driver, CMN1000.class);

		// [確認]
		Assert.assertThat("タイトルが期待値と異なる", this.driver.getTitle(), is(CMN1000.TITLE));
		Assert.assertThat("ログインIDが期待値と異なる", page.getLoginId(), is(""));
		Assert.assertThat("パスワードが期待値と異なる", page.getPassword(), is(""));
	}

	@Test
	public void ログイン画面はログイン済みの場合にトップ画面に遷移すること() {
		// [準備]
		this.driver.get(CMN1000.URL);
		CMN1000 page = PageFactory.initElements(this.driver, CMN1000.class);
		page.setLoginId("admin");
		page.setPassword("admin");
		page.login();

		// [実行]
		this.driver.get(CMN1000.URL);

		// [確認]
		Assert.assertThat("タイトルが期待値と異なる", this.driver.getTitle(), is(CMN1010.TITLE));
	}

	private void waitForSeconds(WebDriver driver, int seconds) {
		new WebDriverWait(driver, seconds).until(new ExpectedCondition<Boolean>()
		{
			@Override
			public Boolean apply(WebDriver driver) {
				return false;
			}
		});
	}

	private void waitForDeleteInvalidAccess() {
		try {
			this.waitForSeconds(this.driver, 60 + 1);
		} catch (TimeoutException ex) {
			// NOP
		}
	}

	@Test
	public void ログイン画面はログイン失敗の場合に失敗メッセージを表示すること() {

		// [準備]
		this.waitForDeleteInvalidAccess();

		// [実行]
		this.driver.get(CMN1000.URL);
		CMN1000 page = PageFactory.initElements(driver, CMN1000.class);
		page.setLoginId("hoge");
		page.setPassword("fuga");
		page.login();

		// [確認]
		Assert.assertThat("タイトルが期待値と異なる", this.driver.getTitle(), is(CMN1000.TITLE));
		Assert.assertThat("失敗メッセージが期待値と異なる", this.driver.findElement(By.cssSelector("section#alerts div")).getText(), is(CMN1000.MESSAGE_FAIL_LOGIN));
		Assert.assertThat("ログインIDが期待値と異なる", page.getLoginId(), is(""));
		Assert.assertThat("パスワードが期待値と異なる", page.getPassword(), is(""));
	}

	@Test
	public void ログイン画面は3回連続ログイン失敗の場合に失敗メッセージを表示しログインを抑止すること() {

		// [準備]
		this.waitForDeleteInvalidAccess();

		// [実行]
		this.driver.get(CMN1000.URL);
		CMN1000 page = PageFactory.initElements(driver, CMN1000.class);
		for(int i = 0; i < 3; i++) {
			page.setLoginId("hoge");
			page.setPassword("fuga");
			page.login();
		}

		// [確認]
		Assert.assertThat("タイトルが期待値と異なる", this.driver.getTitle(), is(CMN1000.TITLE));
		Assert.assertThat("失敗メッセージが期待値と異なる", this.driver.findElement(By.cssSelector("section#alerts div")).getText(), is(CMN1000.MESSAGE_FAIL_LOGIN));
		Assert.assertThat("ログイン可能状態である", page.canLogin(), is(false));

		// [後処理
		this.waitForDeleteInvalidAccess();

	}

}
