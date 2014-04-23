CREATE TABLE `xplugin_agws_nosto_track_recommendations` (
  `iNostoRecommendationsSlotID` int(5) NOT NULL AUTO_INCREMENT,
  `iSideID` int(3) NOT NULL,
  `cCSSSelektor` varchar(255) NOT NULL,
  `cPQueryMethode` varchar(255) NOT NULL,
  `cRecommendationsSlotID` varchar(255) NOT NULL,
  `bActivate` tinyint(1) NOT NULL,
  PRIMARY KEY (`iNostoRecommendationsSlotID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
