alter table  news add COLUMN isbest TINYINT DEFAULT 0;

alter table  demand add COLUMN age TINYINT DEFAULT 0;
alter table  demand add COLUMN weight INT DEFAULT 0;

alter table demand MODIFY  COLUMN strength FLOAT(4,2);
alter table demand MODIFY  COLUMN sporttime FLOAT(4,2);