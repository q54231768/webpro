 create database laravelwebpro;
 use laravelwebpro;
 CREATE TABLE user(
  user_id char(15) NOT NULL COMMENT '用户账号',
  user_name varchar(20) NOT NULL COMMENT '用户昵称',
  email varchar(40) NOT NULL COMMENT '用户邮箱',
  password char(32) NOT NULL COMMENT '用户密码',
  delete_time bigint(20) NOT NULL COMMENT '用户删除时间,0代表用户账号有效,大于0代表用户失效,数值代表用户失效的时间需要转为时间戳',
  create_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '用户注册时间',
  last_login_time timestamp NOT NULL COMMENT '用户上次登录时间',
  landing_times int(10) NOT NULL COMMENT '用用户登录次数',
  PRIMARY KEY (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户信息表';    