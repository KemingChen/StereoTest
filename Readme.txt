Apache設定
	1. 要記的修改 php.ini 中的 date.timezone=Asia/Taipei; 時間才會對


使用方法
	5.1聲道的表格
	http://140.124.181.7:1221/Public/StereoTest/temp.php?channel=5

	8聲道的表格
	http://140.124.181.7:1221/Public/StereoTest/temp.php?channel=8

	產生報表
	http://140.124.181.7:1221/Public/StereoTest/Report.php


	表格使用方法
		1. 最上面的 RadioButton 是聽到的聲音來的方向

		2. Save 上方有數字的格子是題號

		3. 按下 Save 後，系統會自動記錄剛剛所選的方向，並把題數 +1

		4. 如果有做錯的化，修改題數即可重新作答此題

		5. 作答完畢，把中間大框框的資訊記錄到記事本-> 此資訊稱為[我的答案]


	報表使用方法
		1. 把 [我的答案] 複製到左邊框框

		2. 把 .m3u 檔案依序貼入右邊框框

		3. 按下 "審查" 會有 CSV 可供下載