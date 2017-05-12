insert into stock_user(username, password, email, phone_number)
values ('trainsn','123456a','shaoxinxiaosai@163.com','17816878712');
insert into stock_user(username, password, email, phone_number)
values ('iamuser','111111','shaoxinxiaosai@163.com','17816878712');

insert into stock_stock(stockid,stockname,isRaise,price,totalStockNum)
	values('000856', '冀东装备',1,25.39,1000000);

insert into stock_stockholder(stockholderid, userid)
	values(1, 1);
insert into stock_stockholder(stockholderid, userid)
	values(2, 2);

insert into stock_hold_stock_info
	values(1, '000856', 1000, 1000, 10);

insert into stock_deal
	values(1,'000856',10.2, 1492772166, 100, 1020, 8, 6);
insert into stock_deal
	values(2,'000856',10.2, 1494557704, 100, 1020, 8, 6);

insert into stock_personal_stock_account(bankrollid,bankroll,
	bankroll_usable,bankroll_freezed, total ,total_stock,userid)
	values(1, 95784, 95634, 150, 100150, 4366, 1);