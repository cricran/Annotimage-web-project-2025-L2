create table annotimage.user (
	id int auto_increment primary key,
	username varchar(64) not null,
    email varchar(255) not null,
    password varchar(64) not null
)engine InnoDB;

create table annotimage.image (
	id int auto_increment primary key,
    path varchar(255) not null,
	description varchar(1024) not null,
    public boolean default false,
    date datetime not null,
    userId int not null,
    foreign key (userId) references user(id)
)engine InnoDB;

create table annotimage.annotation (
	id int auto_increment primary key,
    imageId int not null,
    description varchar(1024) not null,
    foreign key (imageId) references image(id)
)engine InnoDB;

create table annotimage.tag (
	id int auto_increment primary key,
	name varchar(64) not null
)engine InnoDB;

create table annotimage.taged (
	imageId int,
    tagId int,
    foreign key (imageId) references image(id),
    foreign key (tagId) references tag(id)
)engine InnoDB;
    





