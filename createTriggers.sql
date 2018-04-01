CREATE OR REPLACE FUNCTION passwordTooShort()
	RETURNS TRIGGER AS $$
	BEGIN
		raise EXCEPTION 'Password is less than 8 characters!';
		return null;
	END;
	$$ LANGUAGE plpgsql;

create trigger passwordTooShort
	before insert or UPDATE
	on users
	for each ROW
	when (char_length(new.pssword) < 8)
	EXECUTE PROCEDURE passwordTooShort();

create or replace function samePassword()
	returns trigger as $$
	BEGIN
		raise exception 'Password was not changed!';
		return null;
	END;
	$$ language plpgsql;

create trigger samePasswordError
	before update
	on users
	for each ROW
	when (old.pssword = new.pssword AND old.billingAddress = new.billingAddress AND old.isAdmin = new.isAdmin AND old.isBanned = new.isBanned)
	EXECUTE PROCEDURE samePassword();
