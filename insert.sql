insert into stock_user(username, password, email, phone_number)
values ('trainsn','25d55ad283aa400af464c76d713c07ad','shaoxinxiaosai@163.com','17816878712'); #密码采用MD5加密，实际密码为12345678
insert into stock_user(username, password, email, phone_number)
values ('iamuser','1bbd886460827015e5d605ed44252251','shaoxinxiaosai@163.com','17816878712'); #密码采用MD5加密，实际密码为11111111


insert into stock_stock(stockid,stockname,isRaise,price,totalStockNum)
	values('000856', '冀东装备',1,25.39,1000000);

insert into stock_stockholder(stockholderid, userid)
	values(1, 1);
insert into stock_stockholder(stockholderid, userid)
	values(2, 2);

insert into stock_hold_stock_info
	values(1, '000856', 1000, 1000, 10);

insert into stock_deal(dealid,stockid,deal_price,deal_time,dealed_amount, dealed_value,in_commission,out_commission)
	values(1,'000856',10.2, 1492772166, 100, 1020, 7, 6); #最后两个字段需要根据实际的委托记录进行修改
insert into stock_deal
	values(2,'000856',10.2, 1494557704, 100, 1020, 8, 6);

insert into stock_personal_stock_account(bankrollid,bankroll,
	bankroll_usable,bankroll_freezed, total ,total_stock,userid)
	values(1, 95784, 95634, 150, 100150, 4366, 1); 
insert into stock_personal_stock_account(bankrollid,bankroll,
	bankroll_usable,bankroll_freezed, total ,total_stock,userid)
	values(2, 95784, 95634, 150, 100150, 4366, 2);
insert into stock_personal_stock_account(bankrollid,bankroll,
	bankroll_usable,bankroll_freezed, total ,total_stock,userid)
	values(3, 95784, 95634, 150, 100150, 4366, 2);