SELECT p.Nome,p.Cognome,r.Prov AS ProvDiProvenienza, cc.Piazzamento, co.NomeCorsa, 
       l1.Localita AS Partenza, l1.Prov AS ProvPartenza, l2.Localita AS Arrivo, l2.Prov AS ProvArrivo 
FROM PersoneFisiche p, Recapiti r, CiclistiCorse cc, Corse co, Luoghi l1, Luoghi l2
WHERE p.Id = r.Id AND p.Id = cc.Id AND cc.IdCorsa = co.IdCorsa AND cc.Piazzamento <> 0 
      AND co.Partenza = l1.CAP AND co.Arrivo = l2.CAP AND (r.Prov = l1.Prov OR r.Prov = l2.Prov);
